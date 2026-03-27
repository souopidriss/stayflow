<?php

namespace App\Http\Controllers\Receptionniste;

use App\Http\Controllers\Controller;
use App\Models\Facture;
use App\Models\Paiement;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class FactureController extends Controller
{
    public function index()
    {
        $factures = Facture::with(['reservation.client', 'reservation.chambre'])
            ->latest()->get();
        return view('reception.factures.index', compact('factures'));
    }

    public function show(Facture $facture)
    {
        $facture->load(['reservation.client', 'reservation.chambre.typeChambre', 'paiements']);
        return view('reception.factures.show', compact('facture'));
    }

    public function create()
    {
        return redirect()->route('reception.factures.index');
    }

    public function store(Request $request)
    {
        return redirect()->route('reception.factures.index');
    }

    public function edit(Facture $facture)
    {
        return view('reception.factures.edit', compact('facture'));
    }

    public function update(Request $request, Facture $facture)
    {
        $request->validate([
            'statut'        => 'required|in:non_payee,payee,partielle',
            'mode_paiement' => 'required_if:statut,payee|in:especes,carte,mobile_money,virement,cheque',
        ], [
            'statut.required'               => 'Le statut est obligatoire.',
            'mode_paiement.required_if'     => 'Le mode de paiement est obligatoire.',
        ]);

        $facture->update(['statut' => $request->statut]);

        if ($request->statut === 'payee') {
            Paiement::create([
                'id_facture'    => $facture->id_facture,
                'date_paiement' => now(),
                'montant'       => $facture->montant_total,
                'mode_paiement' => $request->mode_paiement,
                'statut'        => 'valide',
            ]);
        }

        return redirect()->route('reception.factures.index')
            ->with('success', 'Facture mise à jour avec succès !');
    }

    public function destroy(Facture $facture)
    {
        $facture->delete();
        return redirect()->route('reception.factures.index')
            ->with('success', 'Facture supprimée avec succès !');
    }

    public function pdf(Facture $facture)
    {
        $facture->load(['reservation.client', 'reservation.chambre.typeChambre', 'paiements']);
        $pdf = Pdf::loadView('reception.factures.pdf', compact('facture'));
        return $pdf->download('facture-' . $facture->id_facture . '.pdf');
    }

    public function payer(Request $request, Facture $facture)
    {
        $request->validate([
            'mode_paiement' => 'required|in:especes,carte,mobile_money,virement,cheque',
        ]);

        $facture->update(['statut' => 'payee']);

        Paiement::create([
            'id_facture'    => $facture->id_facture,
            'date_paiement' => now(),
            'montant'       => $facture->montant_total,
            'mode_paiement' => $request->mode_paiement,
            'statut'        => 'valide',
        ]);

        return redirect()->route('reception.factures.index')
            ->with('success', 'Paiement enregistré avec succès !');
    }
}