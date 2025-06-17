<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Examens extends Model
{
    use HasFactory;

    protected $table = 'examens';
    protected $primaryKey = 'examen_id';

    protected $fillable = [
        'designation',
        'age_requis',
        'description',
    ];

    /**
     * Relations
     */
    
    // Un examen peut avoir plusieurs vaccins
    public function vaccins()
    {
        return $this->hasMany(Vaccin::class, 'examen_id', 'examen_id');
    }

    // Un examen peut avoir plusieurs maladies
    public function maladies()
    {
        return $this->hasMany(Maladies::class, 'examen_id', 'examen_id');
    }

    // Un examen peut avoir plusieurs indices
    public function indices()
    {
        return $this->hasMany(Indice::class, 'examen_id', 'examen_id');
    }

    // Relation many-to-many avec Patient
    public function patients()
    {
        return $this->belongsToMany(Patient::class, 'patient_examens', 'examen_id', 'patient_id')
                    ->withPivot('date', 'date_prch_rdv', 'age', 'temperature', 'poids', 'taille', 'observations', 'sign_cach')
                    ->withTimestamps();
    }

    // Relation many-to-many avec Parents
    public function parents()
    {
        return $this->belongsToMany(Parents::class, 'parent_examens', 'examen_id', 'parent_id')
                    ->withPivot('date', 'observations', 'agent')
                    ->withTimestamps();
    }

    // Relation many-to-many avec Consult
    public function consults()
    {
        return $this->belongsToMany(Consult::class, 'consult_examens', 'examen_id', 'consult_id')
                    ->withPivot('patient_id', 'date')
                    ->withTimestamps();
    }
}