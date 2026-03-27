<?php

namespace App\Http\Controllers\Receptionniste;

use App\Http\Controllers\Controller;
use App\Models\Chambre;
use App\Models\TypeChambre;
use Illuminate\Http\Request;

class ChambreController extends Controller
{
    public function index()
    {
        $chambres = Chambre::with('typeChambre')->latest()->get();
        return view('reception.chambres.index', compact('chambres'));
    }

    public function create()
    {
        $types = TypeChambre::all();
        return view('reception.chambres.create', compact('types'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_type'   => 'required|exists:type_chambres,id_type',
            'numero'    => 'required|string|unique:chambres,numero',
            'prix_nuit' => 'required|numeric|min:0',
            'statut'    => 'required|in:Libre,Occupé,Maintenance',
        ]);

        Chambre::create($request->all());

        return redirect()->route('reception.chambres.index')
            ->with('success', 'Chambre créée avec succès !');
    }

    public function show(Chambre $chambre)
    {
        $chambre->load('typeChambre', 'reservations.client');
        return view('reception.chambres.show', compact('chambre'));
    }

    public function edit(Chambre $chambre)
    {
        $types = TypeChambre::all();
        return view('reception.chambres.edit', compact('chambre', 'types'));
    }

    public function update(Request $request, Chambre $chambre)
    {
        $request->validate([
            'id_type'   => 'required|exists:type_chambres,id_type',
            'numero'    => 'required|string|unique:chambres,numero,'.$chambre->id_chambre.',id_chambre',
            'prix_nuit' => 'required|numeric|min:0',
            'statut'    => 'required|in:Libre,Occupé,Maintenance',
        ]);

        $chambre->update($request->all());

        return redirect()->route('reception.chambres.index')
            ->with('success', 'Chambre modifiée avec succès !');
    }

    public function destroy(Chambre $chambre)
    {
        if ($chambre->reservations()->count() > 0) {
            return redirect()->route('reception.chambres.index')
                ->with('error', 'Impossible de supprimer cette chambre car elle a des réservations.');
        }

        $chambre->delete();

        return redirect()->route('reception.chambres.index')
            ->with('success', 'Chambre supprimée avec succès !');
    }
}