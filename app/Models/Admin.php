<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $table = 'admin';
    protected $primaryKey = 'admin_id';

    protected $fillable = [
        'user_id',
    ];

    // Relation inverse avec Users : un administrateur appartient à un utilisateur
    public function user()
    {
        return $this->belongsTo(Users::class, 'user_id', 'user_id');
    }

    // Relation 1:n avec Agent
    public function agents()
    {
        return $this->hasMany(Agent::class, 'admin_id', 'admin_id');
    }
}
