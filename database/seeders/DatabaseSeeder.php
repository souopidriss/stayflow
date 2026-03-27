<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Client;
use App\Models\Employe;
use App\Models\TypeChambre;
use App\Models\Chambre;
use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Super Admin
        $admin = User::create([
            'name'     => 'Administrateur',
            'email'    => 'admin@stayflow.cm',
            'password' => Hash::make('password'),
            'role'     => 'super_admin',
        ]);
        Employe::create([
            'user_id'    => $admin->id,
            'nom'        => 'Admin',
            'prenom'     => 'Super',
            'poste'      => 'Directeur',
            'telephone'  => '+237 699 000 001',
        ]);

        // Réceptionniste
        $recep = User::create([
            'name'     => 'Marie Nguemo',
            'email'    => 'reception@stayflow.cm',
            'password' => Hash::make('password'),
            'role'     => 'receptionniste',
        ]);
        Employe::create([
            'user_id'    => $recep->id,
            'nom'        => 'Nguemo',
            'prenom'     => 'Marie',
            'poste'      => 'Réceptionniste',
            'telephone'  => '+237 699 000 002',
        ]);

        // Client test
        $userClient = User::create([
            'name'     => 'Jean Dupont',
            'email'    => 'client@stayflow.cm',
            'password' => Hash::make('password'),
            'role'     => 'client',
        ]);
        Client::create([
            'user_id'   => $userClient->id,
            'nom'       => 'Dupont',
            'prenom'    => 'Jean',
            'telephone' => '+237 690 000 000',
            'email'     => 'client@stayflow.cm',
            'adresse'   => 'Yaoundé, Cameroun',
        ]);

        // Types de chambres
        $types = [
            ['libelle_type' => 'Chambre Simple',       'capacite' => 1, 'prix_nuit' => 15000],
            ['libelle_type' => 'Chambre Double',        'capacite' => 2, 'prix_nuit' => 25000],
            ['libelle_type' => 'Suite Junior',          'capacite' => 2, 'prix_nuit' => 45000],
            ['libelle_type' => 'Suite Présidentielle',  'capacite' => 4, 'prix_nuit' => 80000],
        ];
        foreach ($types as $type) {
            TypeChambre::create($type);
        }

        // Chambres
        $chambres = [
            ['id_type' => 1, 'numero' => '101', 'prix_nuit' => 15000, 'statut' => 'Libre'],
            ['id_type' => 1, 'numero' => '102', 'prix_nuit' => 15000, 'statut' => 'Libre'],
            ['id_type' => 2, 'numero' => '201', 'prix_nuit' => 25000, 'statut' => 'Libre'],
            ['id_type' => 2, 'numero' => '202', 'prix_nuit' => 25000, 'statut' => 'Occupé'],
            ['id_type' => 3, 'numero' => '301', 'prix_nuit' => 45000, 'statut' => 'Libre'],
            ['id_type' => 4, 'numero' => '401', 'prix_nuit' => 80000, 'statut' => 'Libre'],
        ];
        foreach ($chambres as $c) {
            Chambre::create($c);
        }

        // Services
        $services = [
            ['nom' => 'Petit-déjeuner',    'prix' => 3500,  'description' => 'Petit-déjeuner buffet complet'],
            ['nom' => 'Navette aéroport',  'prix' => 10000, 'description' => 'Transfert aller ou retour'],
            ['nom' => 'Spa & Bien-être',   'prix' => 8000,  'description' => 'Accès spa 1 heure'],
            ['nom' => 'Room Service',      'prix' => 2000,  'description' => 'Service en chambre'],
            ['nom' => 'Parking sécurisé', 'prix' => 1500,  'description' => 'Parking privatif par nuit'],
        ];
        foreach ($services as $s) {
            Service::create($s);
        }
    }
}