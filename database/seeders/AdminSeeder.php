<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'firstname' => 'Super',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'genre' => 'masculin',
            'hospital' => 'Hôpital Central',
            'numero_matricule' => 'ADM-001',
            'qualification' => 'Administrateur',
            'date_d_ajout' => now(),
        ]);

        // Créez également un agent pour tester la connexion avec le rôle agent
        User::create([
            'name' => 'Agent',
            'firstname' => 'Test',
            'email' => 'agent@example.com',
            'password' => Hash::make('password'),
            'role' => 'agent',
            'genre' => 'féminin',
            'hospital' => 'Hôpital Central',
            'numero_matricule' => 'AG-001',
            'qualification' => 'Infirmière',
            'date_d_ajout' => now(),
        ]);
    }
}