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
    protected $table = 'users'; // Nom de la table

    protected $primaryKey = 'user_id'; // Clé primaire

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
        'failed_login_attempts',
        'locked_until',
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
        'locked_until' => 'datetime',
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
     * Check if account is locked
     */
    public function isLocked()
    {
        return $this->locked_until && $this->locked_until->isFuture();
    }

    /**
     * Increment failed login attempts
     */
    public function incrementFailedAttempts()
    {
        $this->increment('failed_login_attempts');
        
        if ($this->failed_login_attempts >= 5) {
            $this->lockAccount();
        }
    }

    /**
     * Lock the account for 15 minutes
     */
    public function lockAccount()
    {
        $this->update([
            'locked_until' => now()->addMinutes(15)
        ]);
    }

    /**
     * Reset failed login attempts
     */
    public function resetFailedAttempts()
    {
        $this->update([
            'failed_login_attempts' => 0,
            'locked_until' => null
        ]);
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