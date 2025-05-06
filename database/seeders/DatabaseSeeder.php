<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Création d'un admin pour tester
        User::create([
            'name' => 'Admin',
            'firstname' => 'Système',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'genre' => 'masculin',
            'hospital' => 'Hôpital Central',
            'numero_matricule' => 'ADM001',
            'qualification' => 'Administrateur Système',
            'date_d_ajout' => now(),
        ]);

        // Création d'un agent pour tester
        User::create([
            'name' => 'Dupont',
            'firstname' => 'Jean',
            'email' => 'agent@example.com',
            'password' => Hash::make('password'),
            'role' => 'agent',
            'genre' => 'masculin',
            'hospital' => 'Hôpital Central',
            'numero_matricule' => 'AGT001',
            'qualification' => 'Infirmier',
            'date_d_ajout' => now(),
        ]);
    }
}