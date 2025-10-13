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
        'working_days'
    ];

    protected $casts = [
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i'
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

    // Convert working_days to array when getting from database
    public function getWorkingDaysAttribute($value)
    {
        return explode(',', $value);
    }

    // Convert working_days to string when saving to database
    public function setWorkingDaysAttribute($value)
    {
        $this->attributes['working_days'] = is_array($value) ? implode(',', $value) : $value;
    }
}