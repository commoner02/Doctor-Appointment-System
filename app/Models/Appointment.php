<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'chamber_id',
        'schedule_id',
        'appointment_date',
        'status',
        'reason',
    ];

    protected $casts = [
        'appointment_date' => 'datetime',
    ];

    //Relationships
    public function patient(){
        return $this->belongsTo(Patient::Class);
    }

    public function doctor(){
        return $this->belongsTo(Doctor::Class);
    }

    public function chamber(){
        return $this->belongsTo(Chamber::Class);
    }

    public function schedule(){
        return $this->belongsTo(Schedule::Class);
    }
}
