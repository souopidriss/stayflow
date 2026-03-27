<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Facture;
use Illuminate\Support\Facades\Auth;

class FactureController extends Controller
{
    public function index()
    {
        $client = Auth::user()->client;
        $factures = Facture::with(['reservation.chambre.typeChambre'])
            ->whereHas('reservation', function($q) use ($client) {
                $q->where('id_client', $client->id_client);
            })
            ->latest()
            ->get();
        return view('client.factures.index', compact('factures', 'client'));
    }
}