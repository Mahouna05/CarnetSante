<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Hospital;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Créer un hôpital de test si nécessaire
        $hospital = Hospital::firstOrCreate([
            'nom' => 'Hôpital Central de Cotonou'
        ], [
            'departement' => 'Littoral',
            'ville' => 'Cotonou',
            'quartier_de_ville' => 'Centre-ville',
            'arrondissement' => '1er arrondissement',
            'matricule' => 'HCC001',
        ]);

        // Création du SuperAdmin
        User::firstOrCreate([
            'email' => 'superadmin@sante.bj'
        ], [
            'name' => 'SUPER',
            'firstname' => 'ADMIN',
            'password' => Hash::make('SuperAdmin2024!'),
            'role' => 'super_admin',
            'genre' => 'M',
            'date_d_ajout' => now(),
        ]);

        // Création d'un admin pour tester
        User::firstOrCreate([
            'email' => 'admin@sante.bj'
        ], [
            'name' => 'Admin',
            'firstname' => 'Système',
            'password' => Hash::make('Admin2024!'),
            'role' => 'admin',
            'genre' => 'M',
            'date_d_ajout' => now(),
            'created_by' => 1, // Créé par le SuperAdmin
        ]);

        // Création d'un agent pour tester
        User::firstOrCreate([
            'email' => 'agent@sante.bj'
        ], [
            'name' => 'Dupont',
            'firstname' => 'Jean',
            'password' => Hash::make('Agent2024!'),
            'role' => 'agent',
            'genre' => 'M',
            'hospital_id' => $hospital->hospital_id,
            'numero_matricule' => 'AGT001',
            'qualification' => 'Infirmier',
            'date_d_ajout' => now(),
            'created_by' => 1, // Créé par le SuperAdmin
        ]);
    }
}