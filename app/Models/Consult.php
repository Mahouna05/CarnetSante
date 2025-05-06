<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consult extends Model
{
    use HasFactory;

    protected $table = 'consult';

    protected $primaryKey = 'consult_id';

    protected $fillable = [
        'designation',
        'description',
    ];

    /**
     * Relations
     */

    // Relation many-to-many avec Patient à travers PatientConsult
    public function patients()
    {
        return $this->belongsToMany(
            Patient::class,
            'patient_consult',    // table pivot
            'consult_id',         // Foreign key in pivot table for Consult
            'patient_id'          // Foreign key in pivot table for Patient
        )
        ->withPivot('date', 'observations', 'agent_id', 'hospital_id', 'examen_id', 'sign_cach') // Ajoute les colonnes du pivot
        ->withTimestamps();
    }

    // Relation belongsToMany avec Examen via consult_examens
    public function examens()
    {
        return $this->belongsToMany(
            Examen::class,
            'consult_examens',
            'consult_id',
            'examen_id'
        )
        ->withPivot('patient_id') // Ajoute les colonnes du pivot
        ->withTimestamps();
    }
}
