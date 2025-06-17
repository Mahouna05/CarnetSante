<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Indice extends Model
{
    use HasFactory;

    protected $table = 'indice';
    protected $primaryKey = 'indice_id';

    protected $fillable = [
        'designation',
        'description',
        'indiceName',
        'observations',
        'examen_id',
    ];

    /**
     * Relations
     */
    
    // Un indice appartient à un examen
    public function examen()
    {
        return $this->belongsTo(Examens::class, 'examen_id', 'examen_id');
    }

    // Relation many-to-many avec Patient
    public function patients()
    {
        return $this->belongsToMany(Patient::class, 'patient_indice', 'indice_id', 'patient_id')
                    ->withPivot('observations')
                    ->withTimestamps();
    }
}