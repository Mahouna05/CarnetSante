<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $table = 'patient'; // Nom de la table

    protected $primaryKey = 'patient_id'; // Clé primaire

    protected $fillable = [
        'numero_de_suivi',
        'nom',
        'prenom',
        'date_de_naissance',
        'duree_de_l_accouchement',
        'gender',
        'lieu_de_naissance',
        'empreinte_digitale',
        'motdepasse',
        'QR_code',
    ];

    protected $hidden = [
        'motdepasse', // Cacher le mot de passe dans les réponses JSON
        'empreinte_digitale',
    ];

    protected $casts = [
        'date_de_naissance' => 'date',
        'empreinte_digitale' => 'binary',
    ];

    public function suivis()
    {
        return $this->hasMany(Suivis::class, 'patient_id', 'patient_id');
    }

    public function consultations()
    {
        return $this->belongsToMany(Consult::class, 'patient_consult', 'patient_id', 'consult_id')
                    ->withPivot('date', 'consult', 'observations', 'sign_cach')
                    ->withTimestamps();
    }

    public function maladies()
    {
        return $this->belongsToMany(Maladies::class, 'patient_maladies', 'patient_id', 'maladie_id')
                    ->withPivot('periode', 'observations')
                    ->withTimestamps();
    }

    public function parents()
    {
        return $this->belongsToMany(Parents::class, 'patient_parent', 'patient_id', 'parent_id')
                    ->withTimestamps();
    }

    public function examens()
    {
        return $this->belongsToMany(Examens::class, 'patient_examens', 'patient_id', 'examen_id')
                    ->withPivot('date', 'date_prch_rdv', 'age', 'temperature', 'poids', 'taille', 'observations', 'sign_cach')
                    ->withTimestamps();
    }
    public function suivi()
    {
        return $this->belongsToMany(Indice::class, 'patient_indice', 'patient_id', 'indice_id')
                    ->withPivot('observations')
                    ->withTimestamps();
    }
}
