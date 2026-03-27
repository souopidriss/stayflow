<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employe;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeController extends Controller
{
    public function index()
    {
        $employes = Employe::with('user')->latest()->get();
        return view('admin.employes.index', compact('employes'));
    }

    public function create()
    {
        return view('admin.employes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom'       => 'required|string|max:255',
            'prenom'    => 'required|string|max:255',
            'poste'     => 'required|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:8|confirmed',
        ], [
            'nom.required'    => 'Le nom est obligatoire.',
            'prenom.required' => 'Le prénom est obligatoire.',
            'poste.required'  => 'Le poste est obligatoire.',
            'email.required'  => 'L\'email est obligatoire.',
            'email.unique'    => 'Cet email est déjà utilisé.',
        ]);

        $user = User::create([
            'name'     => $request->prenom . ' ' . $request->nom,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'receptionniste',
        ]);

        Employe::create([
            'user_id'   => $user->id,
            'nom'       => $request->nom,
            'prenom'    => $request->prenom,
            'poste'     => $request->poste,
            'telephone' => $request->telephone,
        ]);

        return redirect()->route('admin.employes.index')
            ->with('success', 'Employé créé avec succès !');
    }

    public function show(Employe $employe)
    {
        $employe->load('user', 'services', 'evaluations');
        return view('admin.employes.show', compact('employe'));
    }

    public function edit(Employe $employe)
    {
        return view('admin.employes.edit', compact('employe'));
    }

    public function update(Request $request, Employe $employe)
    {
        $request->validate([
            'nom'       => 'required|string|max:255',
            'prenom'    => 'required|string|max:255',
            'poste'     => 'required|string|max:255',
            'telephone' => 'nullable|string|max:20',
        ]);

        $employe->update($request->only('nom', 'prenom', 'poste', 'telephone'));

        $employe->user->update([
            'name' => $request->prenom . ' ' . $request->nom,
        ]);

        return redirect()->route('admin.employes.index')
            ->with('success', 'Employé modifié avec succès !');
    }

    public function destroy(Employe $employe)
    {
        $employe->user->delete();
        return redirect()->route('admin.employes.index')
            ->with('success', 'Employé supprimé avec succès !');
    }
}