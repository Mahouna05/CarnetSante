<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use HasFactory;

    // Définir la table associée
    protected $table = 'agent';

    // Définir les relations avec les autres tables

    // Relation avec le modèle Users (1, n)
    public function Users()
    {
        return $this->belongsTo(Users::class, 'user_id', 'user_id');
    }

    // Relation avec le modèle Admin (1, n)
    public function Admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'admin_id');
    }

    // Relation avec la table agent_hospital (n, n) via un modèle intermédiaire
    public function hospitals()
    {
        return $this->belongsToMany(Hospital::class, 'agent_hospital', 'agent_id', 'hospital_id')
                    ->withTimestamps();
    }
}
