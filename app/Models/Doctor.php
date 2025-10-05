<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'department_id',
        'first_name',
        'last_name',
        'speciality',
        'phone',
    ];

    //Relationships
    public function user(){
        return $this->belongsTo(User::Class);
    }

    public function department(){
        return $this->belongsTo(Department::Class);
    }

    public function chambers(){
        return $this->hasMany(Chamber::Class);
    }

    public function schedules(){
        return $this->hasMany(Schedule::Class);
    }

    public function appointments(){
        return $this->hasMany(Appointment::Class);
    }
}