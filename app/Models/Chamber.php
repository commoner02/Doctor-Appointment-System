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
    ];

    //Relationships
    public function doctor(){
        return $this->belongsTo(Doctor::Class);
    }

    public function schedules(){
        return $this->hasMany(Schedule::Class);
    }

    public function appointments(){
        return $this->hasMany(Appointment::Class);
    }
}