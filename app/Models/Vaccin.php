<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vaccin extends Model
{
    use HasFactory;

    protected $table = 'vaccin';
    protected $primaryKey = 'vaccin_id';

    protected $fillable = [
        'nom',
        'categorie',
        'num_de_lot',
        'age_requis',
        'description',
        'examen_id',
    ];

    public function examen()
    {
        return $this->belongsTo(Examen::class, 'examen_id', 'examen_id');
    }

    public function patients()
    {
        return $this->belongsToMany(Patient::class, 'patient_vaccin', 'vaccin_id', 'patient_id')
                    ->withPivot('date', 'RDV', 'etat', 'agent_id', 'hospital_id')
                    ->withTimestamps();
    }
}
