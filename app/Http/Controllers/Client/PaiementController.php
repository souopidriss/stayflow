<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Facture;
use App\Models\Paiement;
use App\Models\OtpPaiement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaiementController extends Controller
{
    public function index(Facture $facture)
    {
        $client = Auth::user()->client;

        if ($facture->reservation->id_client !== $client->id_client) {
            abort(403);
        }

        return view('client.paiements.index', compact('facture'));
    }

    public function initier(Request $request, Facture $facture)
    {
        $request->validate([
            'operateur'  => 'required|in:mtn,orange',
            'telephone'  => 'required|digits:9',
        ], [
            'operateur.required'  => 'Veuillez choisir un opérateur.',
            'telephone.required'  => 'Le numéro de téléphone est obligatoire.',
        ]);

        // Supprimer les anciens OTP
        OtpPaiement::where('id_facture', $facture->id_facture)
            ->where('utilise', false)
            ->delete();

        // Générer nouveau code OTP
        $code = OtpPaiement::genererCode();

        OtpPaiement::create([
            'id_facture'  => $facture->id_facture,
            'telephone'   => $request->telephone,
            'code_otp'    => $code,
            'operateur'   => $request->operateur,
            'utilise'     => false,
            'expire_at'   => now()->addMinutes(5),
        ]);

        return redirect()->route('client.paiements.confirmer', $facture->id_facture)
            ->with('otp_info', [
                'code'      => $code,
                'telephone' => $request->telephone,
                'operateur' => $request->operateur,
            ]);
    }

    public function confirmer(Facture $facture)
    {
        $client = Auth::user()->client;

        if ($facture->reservation->id_client !== $client->id_client) {
            abort(403);
        }

        $otp = OtpPaiement::where('id_facture', $facture->id_facture)
            ->where('utilise', false)
            ->latest()
            ->first();

        if (!$otp) {
            return redirect()->route('client.paiements.index', $facture->id_facture)
                ->with('error', 'Aucun code OTP trouvé. Veuillez recommencer.');
        }

        return view('client.paiements.confirmer', compact('facture', 'otp'));
    }

  public function valider(Request $request, Facture $facture)
{
    $request->validate([
        'code_otp' => 'required|string|size:6',
    ], [
        'code_otp.required' => 'Le code OTP est obligatoire.',
        'code_otp.size'     => 'Le code OTP doit contenir 6 chiffres.',
    ]);

    $otp = OtpPaiement::where('id_facture', $facture->id_facture)
        ->where('utilise', false)
        ->latest()
        ->first();

    if (!$otp) {
        return back()->withErrors(['code_otp' => 'Code OTP invalide.']);
    }

    if ($otp->isExpire()) {
        return back()->withErrors(['code_otp' => 'Code OTP expire. Veuillez recommencer.']);
    }

    if ($otp->code_otp !== $request->code_otp) {
        return back()->withErrors(['code_otp' => 'Code OTP incorrect. Verifiez et reessayez.']);
    }

    // Marquer OTP comme utilisé
    $otp->update(['utilise' => true]);

    // Enregistrer le paiement
    Paiement::create([
        'id_facture'    => $facture->id_facture,
        'date_paiement' => now(),
        'montant'       => $facture->montant_total,
        'mode_paiement' => 'mobile_money',
        'statut'        => 'valide',
    ]);

    // Mettre à jour la facture
    $facture->update(['statut' => 'payee']);

    // Recharger la facture avec ses relations
    $facture->load(['reservation.client', 'reservation.chambre']);

    // Envoyer notification à la réceptionniste
    \App\Models\Notification::notifierPaiement($facture);

    return redirect()->route('client.paiements.recu', $facture->id_facture)
        ->with('success', 'Paiement effectue avec succes !');
}

    public function recu(Facture $facture)
    {
        $client = Auth::user()->client;

        if ($facture->reservation->id_client !== $client->id_client) {
            abort(403);
        }

        $facture->load(['reservation.chambre.typeChambre', 'paiements']);
        return view('client.paiements.recu', compact('facture'));
    }
}