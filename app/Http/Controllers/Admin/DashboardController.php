<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chambre;
use App\Models\Client;
use App\Models\Employe;
use App\Models\Facture;
use App\Models\Reservation;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_chambres'      => Chambre::count(),
            'chambres_libres'     => Chambre::where('statut', 'Libre')->count(),
            'chambres_occupees'   => Chambre::where('statut', 'Occupé')->count(),
            'total_clients'       => Client::count(),
            'total_reservations'  => Reservation::count(),
            'reservations_today'  => Reservation::whereDate('date_arrivee', today())->count(),
            'total_employes'      => Employe::count(),
            'factures_non_payees' => Facture::where('statut', 'non_payee')->count(),
            'revenus_total'       => Facture::where('statut', 'payee')->sum('montant_total'),
        ];

        $reservations_recentes = Reservation::with(['client', 'chambre'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'reservations_recentes'));
    }
}