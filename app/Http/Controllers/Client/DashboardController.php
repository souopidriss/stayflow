<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Chambre;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $client = $user->client;

        $reservations = Reservation::with(['chambre', 'facture'])
            ->where('id_client', $client->id_client)
            ->latest()
            ->get();

        $stats = [
            'total_reservations' => $reservations->count(),
            'reservations_actives' => $reservations->whereIn('statut', ['confirmee', 'checkin'])->count(),
            'reservations_terminees' => $reservations->where('statut', 'checkout')->count(),
        ];

        $chambres_disponibles = Chambre::with('typeChambre')
            ->where('statut', 'Libre')
            ->take(6)
            ->get();

        return view('client.dashboard', compact('stats', 'reservations', 'chambres_disponibles', 'client'));
    }
}