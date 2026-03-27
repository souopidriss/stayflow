<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Chambre;

class ChambreController extends Controller
{
    public function index()
    {
        $chambres = Chambre::with('typeChambre')
            ->where('statut', 'Libre')
            ->get();
        return view('client.chambres.index', compact('chambres'));
    }
}