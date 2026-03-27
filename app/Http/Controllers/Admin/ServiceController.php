<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Employe;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::with('employe')->latest()->get();
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        $employes = Employe::all();
        return view('admin.services.create', compact('employes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom'        => 'required|string|max:255',
            'prix'       => 'required|numeric|min:0',
            'description'=> 'nullable|string',
            'id_employe' => 'nullable|exists:employes,id_employe',
        ], [
            'nom.required'  => 'Le nom du service est obligatoire.',
            'prix.required' => 'Le prix est obligatoire.',
        ]);

        Service::create($request->all());

        return redirect()->route('admin.services.index')
            ->with('success', 'Service créé avec succès !');
    }

    public function show(Service $service)
    {
        return view('admin.services.show', compact('service'));
    }

    public function edit(Service $service)
    {
        $employes = Employe::all();
        return view('admin.services.edit', compact('service', 'employes'));
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'nom'        => 'required|string|max:255',
            'prix'       => 'required|numeric|min:0',
            'description'=> 'nullable|string',
            'id_employe' => 'nullable|exists:employes,id_employe',
        ]);

        $service->update($request->all());

        return redirect()->route('admin.services.index')
            ->with('success', 'Service modifié avec succès !');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('admin.services.index')
            ->with('success', 'Service supprimé avec succès !');
    }
}