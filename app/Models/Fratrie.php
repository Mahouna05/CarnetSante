<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fratrie extends Model
{
    use HasFactory;

    protected $primaryKey = 'fratrie_id'; // car ta clé primaire est fratrie_id

    protected $fillable = [
        'date_de_naissance',
        'sexe',
        'vivant_sante',
        'decede_age',
        'decedes_causes',
    ];

    /**
     * Les patients liés à cette fratrie.
     */
    public function patients()
    {
        return $this->belongsToMany(Patient::class, 'patient_fratrie', 'fratrie_id', 'patient_id')
                    ->withTimestamps();
    }
}
