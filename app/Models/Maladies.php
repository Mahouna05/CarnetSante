<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maladies extends Model
{
    use HasFactory;

    protected $table = 'maladies';

    protected $primaryKey = 'maladie_id';

    protected $fillable = [
        'designation',
        'description',
        'concerné',
        'examen_id',
    ];

    /**
     * Relations
     */
    public function examen()
    {
        return $this->belongsTo(Examens::class, 'examen_id', 'examen_id');
    }

    public function parents()
    {
        return $this->belongsToMany(Parents::class, 'parents_maladies', 'maladie_id', 'parent_id')
            ->withPivot('observations')
            ->withTimestamps();
    }

    public function patients()
    {
        return $this->belongsToMany(Patient::class, 'patient_maladies', 'maladie_id', 'patient_id')
            ->withPivot('periode', 'observations')
            ->withTimestamps();
    }

}
