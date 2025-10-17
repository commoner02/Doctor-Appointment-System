<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'chamber_id',
        'appointment_date',
        'appointment_status',
        'payment_status',
        'reason',
        'notes'
    ];

    protected $casts = [
        'appointment_date' => 'datetime'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function chamber()
    {
        return $this->belongsTo(Chamber::class);
    }
}