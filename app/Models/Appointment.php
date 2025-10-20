<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use function Laravel\Prompts\note;

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
        'note'
    ];

    protected $casts = [
        'appointment_date' => 'datetime',
    ];

    // Relationships
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

    // Helper methods for appointment status
    public function isScheduled()
    {
        return $this->appointment_status === 'scheduled';
    }

    public function isCompleted()
    {
        return $this->appointment_status === 'completed';
    }

    public function isCancelled()
    {
        return $this->appointment_status === 'cancelled';
    }

    // Helper methods for payment status
    public function isPaid()
    {
        return $this->payment_status === 'paid';
    }

    public function isUnpaid()
    {
        return $this->payment_status === 'unpaid';
    }
}