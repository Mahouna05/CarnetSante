<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'firstname',
        'role',
        'genre',
        'email',
        'password',
        'hospital',
        'numero_matricule',
        'qualification',
        'date_d_ajout',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'date_d_ajout' => 'datetime',
    ];

    /**
     * Check if user is admin
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is agent
     */
    public function isAgent()
    {
        return $this->role === 'agent';
    }
    /**
     * Check if user is super-Admin
     */
    public function isSuper()
    {
        return $this->role === 'super_admin';
    }

    /**
     * Get the hospital associated with the user
     */
    public function hospital()
    {
        return $this->belongsTo(Hospital::class, 'hospital', 'hospital_id');
    }

    /**
     * Get users created by this admin
     */
    public function createdUsers()
    {
        return $this->hasMany(User::class, 'created_by');
    }
}