<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'registration_data',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'registration_data' => 'array',
    ];

    // Relationships
    public function doctor()
    {
        return $this->hasOne(Doctor::class);
    }

    public function patient()
    {
        return $this->hasOne(Patient::class);
    }

    // Helper methods for role checking
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isPatient()
    {
        return $this->role === 'patient';
    }

    public function isDoctor()
    {
        return $this->role === 'doctor' && $this->status === 'active' && $this->doctor;
    }

    public function isPendingDoctor()
    {
        return $this->role === 'doctor' && $this->status === 'pending';
    }

    public function canLogin()
    {
        return $this->status === 'active';
    }


    // Safe method to get doctor ID
    public function getDoctorId()
    {
        return $this->doctor ? $this->doctor->id : null;
    }

    // Safe method to get patient ID
    public function getPatientId()
    {
        return $this->patient ? $this->patient->id : null;
    }
}
