<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'gender',
        'phone',
        'address',
        'date_of_birth',
    ];

    //Relationships
    public function user(){
        return $this->belongsTo(User::Class);
    }

    public function appointments(){
        return $this->hasMany(Appointment::Class);
    }
}