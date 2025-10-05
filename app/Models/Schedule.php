<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'chamber_id',
        'day',
        'start_time',
        'end_time',
        'slot_duration',
        'is_available',
    ];

    //Relationships
    public function doctor(){
        return $this->belongsTo(Doctor::Class);
    }

    public function chamber(){
        return $this->belongsTo(Chamber::Class);
    }
    
    public function appointments(){
        return $this->hasMany(Appointment::Class);
    }
}