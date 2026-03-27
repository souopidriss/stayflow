<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::with('user')->latest()->get();
        return view('admin.clients.index', compact('clients'));
    }

    public function create()
    {
        return view('admin.clients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom'       => 'required|string|max:255',
            'prenom'    => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'telephone' => 'nullable|string|max:20',
            'adresse'   => 'nullable|string|max:255',
            'password'  => 'required|min:8|confirmed',
        ], [
            'nom.required'    => 'Le nom est obligatoire.',
            'prenom.required' => 'Le prénom est obligatoire.',
            'email.required'  => 'L\'email est obligatoire.',
            'email.unique'    => 'Cet email est déjà utilisé.',
            'password.min'    => 'Le mot de passe doit contenir au moins 8 caractères.',
        ]);

        $user = User::create([
            'name'     => $request->prenom . ' ' . $request->nom,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'client',
        ]);

        Client::create([
            'user_id'   => $user->id,
            'nom'       => $request->nom,
            'prenom'    => $request->prenom,
            'telephone' => $request->telephone,
            'email'     => $request->email,
            'adresse'   => $request->adresse,
        ]);

        return redirect()->route('admin.clients.index')
            ->with('success', 'Client créé avec succès !');
    }

    public function show(Client $client)
    {
        $client->load('reservations.chambre', 'evaluations');
        return view('admin.clients.show', compact('client'));
    }

    public function edit(Client $client)
    {
        return view('admin.clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $request->validate([
            'nom'       => 'required|string|max:255',
            'prenom'    => 'required|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'adresse'   => 'nullable|string|max:255',
        ]);

        $client->update($request->only('nom', 'prenom', 'telephone', 'adresse'));

        $client->user->update([
            'name' => $request->prenom . ' ' . $request->nom,
        ]);

        return redirect()->route('admin.clients.index')
            ->with('success', 'Client modifié avec succès !');
    }

    public function destroy(Client $client)
    {
        if ($client->reservations()->count() > 0) {
            return redirect()->route('admin.clients.index')
                ->with('error', 'Impossible de supprimer ce client car il a des réservations.');
        }

        $client->user->delete();

        return redirect()->route('admin.clients.index')
            ->with('success', 'Client supprimé avec succès !');
    }
}