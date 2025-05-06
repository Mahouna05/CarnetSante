<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    use HasFactory;

    protected $table = 'hospital';
    protected $primaryKey = 'hospital_id';

    protected $fillable = [
        'departement',
        'ville',
        'nom',
        'quartier_de_ville',
        'arrondissement',
        'matricule',
    ];

    /**
     * Relations
     */

    // Un hôpital a plusieurs suivis
    public function suivis()
    {
        return $this->hasMany(Suivis::class, 'hospital_id', 'hospital_id');
    }

    // Un hôpital a plusieurs agents via la table pivot agent_hospital
    public function agents()
    {
        return $this->belongsToMany(Agent::class, 'agent_hospital', 'hospital_id', 'agent_id');
    }

    // Un hôpital a plusieurs consultations patient
    public function patientConsults()
    {
        return $this->hasMany(PatientConsult::class, 'hospital_id', 'hospital_id');
    }

    // Un hôpital a plusieurs examens de parents
    public function parentExamens()
    {
        return $this->hasMany(ParentExamen::class, 'hospital_id', 'hospital_id');
    }

    // Un hôpital a plusieurs examens de patients
    public function patientExamens()
    {
        return $this->hasMany(PatientExamen::class, 'hospital_id', 'hospital_id');
    }

    // Un hôpital a plusieurs vaccinations de patients
    public function patientVaccins()
    {
        return $this->hasMany(PatientVaccin::class, 'hospital_id', 'hospital_id');
    }
}
