<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Department;

class DoctorController extends Controller
{
    public function browse()
    {
        $departments = Department::with('doctors')->get();
        $doctors = Doctor::with('department', 'user')->get();
        
        return view('doctors.browse', compact('departments', 'doctors'));
    }

    public function show(Doctor $doctor)
    {
        $doctor->load('department', 'schedules.chamber');
        return view('doctors.show', compact('doctor'));
    }
}