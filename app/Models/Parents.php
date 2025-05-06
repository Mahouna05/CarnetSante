<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parents extends Model
{
    use HasFactory;

    // Définir la table associée
    protected $table = 'parents';
    protected $primaryKey = 'parent_id';
    // Définir les colonnes que l'on peut remplir
    protected $fillable = [
        'nom',
        'prenom',
        'age',
        'profession',
        'adresse',
        'contact',
        'lien_de_parente',
    ];

    // Relation avec la table 'Patient' via la table 'patient_parent'
    public function patients()
    {
        return $this->belongsToMany(Patient::class, 'patient_parent', 'parent_id', 'patient_id');
    }

    // Relation avec la table 'maladies' via la table 'parent_maladie'
    public function maladies()
    {
        return $this->belongsToMany(Maladie::class, 'parent_maladie', 'parent_id', 'maladie_id');
    }

    // Relation avec la table 'examens' via la table 'parent_examen'
    public function examens()
    {
        return $this->belongsToMany(Examen::class, 'parent_examen', 'parent_id', 'examen_id');
    }
}
