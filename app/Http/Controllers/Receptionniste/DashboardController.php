<?php

namespace App\Http\Controllers\Receptionniste;

use App\Http\Controllers\Controller;
use App\Models\Chambre;
use App\Models\Client;
use App\Models\Reservation;
use App\Models\Facture;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'chambres_libres'    => Chambre::where('statut', 'Libre')->count(),
            'chambres_occupees'  => Chambre::where('statut', 'Occupé')->count(),
            'reservations_today' => Reservation::whereDate('date_arrivee', today())->count(),
            'checkins_today'     => Reservation::whereDate('date_arrivee', today())
                                        ->where('statut', 'confirmee')->count(),
            'checkouts_today'    => Reservation::whereDate('date_depart', today())
                                        ->where('statut', 'checkin')->count(),
            'factures_en_attente'=> Facture::where('statut', 'non_payee')->count(),
        ];

        $reservations_today = Reservation::with(['client', 'chambre'])
            ->whereDate('date_arrivee', today())
            ->orWhereDate('date_depart', today())
            ->latest()
            ->take(10)
            ->get();

        $chambres_libres = Chambre::with('typeChambre')
            ->where('statut', 'Libre')
            ->get();

        return view('reception.dashboard', compact('stats', 'reservations_today', 'chambres_libres'));
    }
}