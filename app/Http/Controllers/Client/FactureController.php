<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Facture;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class FactureController extends Controller
{
    public function index()
    {
        $client = Auth::user()->client;
        $factures = Facture::with(['reservation.chambre.typeChambre', 'paiements'])
            ->whereHas('reservation', function($q) use ($client) {
                $q->where('id_client', $client->id_client);
            })
            ->latest()
            ->get();
        return view('client.factures.index', compact('factures', 'client'));
    }

    public function detail(Facture $facture)
    {
        $client = Auth::user()->client;
        if ($facture->reservation->id_client !== $client->id_client) {
            abort(403);
        }
        $facture->load(['reservation.chambre.typeChambre', 'paiements']);
        return view('client.factures.detail', compact('facture'));
    }

    public function pdf(Facture $facture)
    {
        $client = Auth::user()->client;
        if ($facture->reservation->id_client !== $client->id_client) {
            abort(403);
        }
        $facture->load(['reservation.chambre.typeChambre', 'paiements']);
        $pdf = Pdf::loadView('client.factures.pdf', compact('facture'));
        return $pdf->download('facture-stayflow-' . $facture->id_facture . '.pdf');
    }
}