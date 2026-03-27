<?php

namespace App\Http\Controllers\Receptionniste;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Client;
use App\Models\Chambre;
use App\Models\Facture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with(['client', 'chambre'])
            ->latest()->get();
        return view('reception.reservations.index', compact('reservations'));
    }

    public function create()
    {
        $clients  = Client::with('user')->get();
        $chambres = Chambre::with('typeChambre')
            ->where('statut', 'Libre')->get();
        return view('reception.reservations.create', compact('clients', 'chambres'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_client'    => 'required|exists:clients,id_client',
            'id_chambre'   => 'required|exists:chambres,id_chambre',
            'date_arrivee' => 'required|date|after_or_equal:today',
            'date_depart'  => 'required|date|after:date_arrivee',
        ], [
            'id_client.required'    => 'Le client est obligatoire.',
            'id_chambre.required'   => 'La chambre est obligatoire.',
            'date_arrivee.required' => 'La date d\'arrivée est obligatoire.',
            'date_depart.after'     => 'La date de départ doit être après la date d\'arrivée.',
        ]);

        $chambre = Chambre::find($request->id_chambre);
        $dateArrivee  = \Carbon\Carbon::parse($request->date_arrivee);
        $dateDepart   = \Carbon\Carbon::parse($request->date_depart);
        $nombreNuits  = $dateArrivee->diffInDays($dateDepart);
        $montantTotal = $nombreNuits * $chambre->prix_nuit;

        $reservation = Reservation::create([
            'id_client'        => $request->id_client,
            'id_chambre'       => $request->id_chambre,
            'date_reservation' => now(),
            'date_arrivee'     => $request->date_arrivee,
            'date_depart'      => $request->date_depart,
            'statut'           => 'confirmee',
        ]);

    $chambre->update(['statut' => 'Occupé']);

        Facture::create([
            'id_reservation' => $reservation->id_reservation,
            'date_facture'   => now(),
            'montant_total'  => $montantTotal,
            'statut'         => 'non_payee',
        ]);

        return redirect()->route('reception.reservations.index')
            ->with('success', 'Réservation créée avec succès !');
    }

    public function show(Reservation $reservation)
    {
        $reservation->load(['client', 'chambre.typeChambre', 'facture']);
        return view('reception.reservations.show', compact('reservation'));
    }

    public function edit(Reservation $reservation)
    {
        $clients  = Client::with('user')->get();
        $chambres = Chambre::with('typeChambre')->get();
        return view('reception.reservations.edit', compact('reservation', 'clients', 'chambres'));
    }

    public function update(Request $request, Reservation $reservation)
    {
        $request->validate([
            'date_arrivee' => 'required|date',
            'date_depart'  => 'required|date|after:date_arrivee',
        ]);

        $reservation->update($request->only('date_arrivee', 'date_depart'));

        return redirect()->route('reception.reservations.index')
            ->with('success', 'Réservation modifiée avec succès !');
    }

    public function updateStatut(Request $request, Reservation $reservation)
    {
        $request->validate([
            'statut' => 'required|in:en_attente,confirmee,checkin,checkout,annulee',
        ]);

        $reservation->update(['statut' => $request->statut]);

        if ($request->statut === 'checkin') {
            $reservation->chambre->update(['statut' => 'Occupé']);
        } elseif (in_array($request->statut, ['checkout', 'annulee'])) {
            $reservation->chambre->update(['statut' => 'Libre']);
        }

        return redirect()->back()
            ->with('success', 'Statut mis à jour avec succès !');
    }

    public function checkin(Request $request, Reservation $reservation)
    {
        $reservation->update(['statut' => 'checkin']);
        $reservation->chambre->update(['statut' => 'Occupé']);

        return redirect()->route('reception.reservations.index')
            ->with('success', 'Check-in effectué avec succès !');
    }

    public function checkout(Request $request, Reservation $reservation)
    {
        $reservation->update(['statut' => 'checkout']);
        $reservation->chambre->update(['statut' => 'Libre']);

        return redirect()->route('reception.reservations.index')
            ->with('success', 'Check-out effectué avec succès !');
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->chambre->update(['statut' => 'Libre']);
        $reservation->delete();

        return redirect()->route('reception.reservations.index')
            ->with('success', 'Réservation supprimée avec succès !');
    }
}