<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suivis extends Model
{
    use HasFactory;

    protected $table = 'suivis'; // Nom de la table
    protected $primaryKey = 'suivi_id'; // Car tu as mis $table->id('suivi_id')
    
    protected $fillable = [
        'date',
        'age',
        'temperature',
        'poids',
        'taille',
        'imc',
        'pb',
        'prescription_et_regime',
        'sign_cach',
        'hospital_id',
        'patient_id',
        'agent_id',
    ];

    /**
     * Relation avec l'hôpital.
     */
    public function hospital()
    {
        return $this->belongsTo(Hospital::class, 'hospital_id', 'hospital_id');
    }

    /**
     * Relation avec le patient.
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'patient_id');
    }

    /**
     * Relation avec l'agent.
     */
    public function agent()
    {
        return $this->belongsTo(Agent::class, 'agent_id', 'agent_id');
    }
}
