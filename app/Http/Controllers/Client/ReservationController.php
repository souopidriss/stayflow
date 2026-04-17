<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Chambre;
use App\Models\Reservation;
use App\Models\Facture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function index()
    {
        $client = Auth::user()->client;
        $reservations = Reservation::with(['chambre.typeChambre', 'facture'])
            ->where('id_client', $client->id_client)
            ->latest()
            ->get();
        return view('client.reservations.index', compact('reservations', 'client'));
    }

    public function create()
    {
        $chambres = Chambre::with('typeChambre')
            ->where('statut', 'Libre')
            ->get();
        return view('client.reservations.create', compact('chambres'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_chambre'   => 'required|exists:chambres,id_chambre',
            'date_arrivee' => 'required|date|after_or_equal:today',
            'date_depart'  => 'required|date|after:date_arrivee',
        ], [
            'id_chambre.required'   => 'Veuillez sélectionner une chambre.',
            'date_arrivee.required' => 'La date d\'arrivée est obligatoire.',
            'date_depart.after'     => 'La date de départ doit être après la date d\'arrivée.',
        ]);

        $client  = Auth::user()->client;
        $chambre = Chambre::find($request->id_chambre);

        $dateArrivee  = \Carbon\Carbon::parse($request->date_arrivee);
        $dateDepart   = \Carbon\Carbon::parse($request->date_depart);
        $nombreNuits  = $dateArrivee->diffInDays($dateDepart);
        $montantTotal = $nombreNuits * $chambre->prix_nuit;

        $reservation = Reservation::create([
            'id_client'        => $client->id_client,
            'id_chambre'       => $request->id_chambre,
            'date_reservation' => now(),
            'date_arrivee'     => $request->date_arrivee,
            'date_depart'      => $request->date_depart,
            'statut'           => 'en_attente',
        ]);

      $chambre->update(['statut' => 'Occupé']);

        Facture::create([
            'id_reservation' => $reservation->id_reservation,
            'date_facture'   => now(),
            'montant_total'  => $montantTotal,
            'statut'         => 'non_payee',
        ]);

        return redirect()->route('client.reservations.index')
            ->with('success', 'Réservation effectuée avec succès ! Nous vous contacterons pour confirmation. 
            Apres que vous aillez reglez votre facture dans la session FACTURE');
    }
}