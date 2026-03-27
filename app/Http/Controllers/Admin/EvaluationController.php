<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Evaluation;
use App\Models\Client;
use App\Models\Employe;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    public function index()
    {
        $evaluations = Evaluation::with(['client', 'employe'])
            ->latest()->get();
        return view('admin.evaluations.index', compact('evaluations'));
    }

    public function create()
    {
        $clients  = Client::with('user')->get();
        $employes = Employe::all();
        return view('admin.evaluations.create', compact('clients', 'employes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_client'    => 'required|exists:clients,id_client',
            'id_employe'   => 'required|exists:employes,id_employe',
            'note'         => 'required|integer|min:1|max:5',
            'commentaire'  => 'nullable|string|max:500',
            'date'         => 'required|date',
        ], [
            'id_client.required'  => 'Le client est obligatoire.',
            'id_employe.required' => 'L\'employé est obligatoire.',
            'note.required'       => 'La note est obligatoire.',
            'note.min'            => 'La note minimum est 1.',
            'note.max'            => 'La note maximum est 5.',
            'date.required'       => 'La date est obligatoire.',
        ]);

        Evaluation::create($request->all());

        return redirect()->route('admin.evaluations.index')
            ->with('success', 'Évaluation créée avec succès !');
    }

    public function show(Evaluation $evaluation)
    {
        $evaluation->load(['client', 'employe']);
        return view('admin.evaluations.show', compact('evaluation'));
    }

    public function edit(Evaluation $evaluation)
    {
        $clients  = Client::with('user')->get();
        $employes = Employe::all();
        return view('admin.evaluations.edit', compact('evaluation', 'clients', 'employes'));
    }

    public function update(Request $request, Evaluation $evaluation)
    {
        $request->validate([
            'id_client'   => 'required|exists:clients,id_client',
            'id_employe'  => 'required|exists:employes,id_employe',
            'note'        => 'required|integer|min:1|max:5',
            'commentaire' => 'nullable|string|max:500',
            'date'        => 'required|date',
        ]);

        $evaluation->update($request->all());

        return redirect()->route('admin.evaluations.index')
            ->with('success', 'Évaluation modifiée avec succès !');
    }

    public function destroy(Evaluation $evaluation)
    {
        $evaluation->delete();
        return redirect()->route('admin.evaluations.index')
            ->with('success', 'Évaluation supprimée avec succès !');
    }
}