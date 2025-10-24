<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'speciality',
        'qualifications',
        'experience',
        'bio',
        'phone',
        'license_number',
        'verification_status',
    ];

    //Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function chambers()
    {
        return $this->hasMany(Chamber::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}