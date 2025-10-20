<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chamber extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'chamber_name',
        'chamber_location',
        'phone',
        'start_time',
        'end_time',
        'visiting_fee',
        'working_days',
    ];

    protected $casts = [
        'working_days' => 'array',
        'visiting_fee' => 'decimal:2'
    ];

    // Relationships
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}