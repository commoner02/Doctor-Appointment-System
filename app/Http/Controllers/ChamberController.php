<?php

namespace App\Http\Controllers;

use App\Models\Chamber;
use Illuminate\Http\Request;

class ChamberController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if (!$user->isDoctor() || !$user->is_verified) {
            abort(403, 'Unauthorized');
        }

        $doctor = $user->doctor;
        $chambers = Chamber::where('doctor_id', $doctor->id)->get();

        return view('doctor.chambers', compact('chambers'));
    }

    public function create()
    {
        return view('chambers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'nullable|string|max:20',
            'working_days' => 'nullable|string|max:255',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
            'fee' => 'nullable|numeric|min:0',
        ]);

        $doctor = auth()->user()->doctor;
        if (!$doctor) {
            return redirect()->back()->with('error', 'Doctor profile not found.');
        }

        Chamber::create([
            'doctor_id' => $doctor->id,
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'working_days' => $request->working_days,
            'start_time' => $request->start_time ?: '09:00',
            'end_time' => $request->end_time ?: '17:00',
            'fee' => $request->fee,
            'is_active' => true,
        ]);

        return redirect()->route('doctor.chambers')->with('success', 'Chamber added successfully!');
    }

    public function edit(Chamber $chamber)
    {
        // Ensure the chamber belongs to the authenticated doctor
        if ($chamber->doctor->user_id !== auth()->id()) {
            abort(403);
        }

        return view('chambers.edit', compact('chamber'));
    }

    public function update(Request $request, Chamber $chamber)
    {
        // Ensure the chamber belongs to the authenticated doctor
        if ($chamber->doctor->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'nullable|string|max:20',
            'working_days' => 'nullable|string|max:255', // Changed from visiting_hours
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
            'fee' => 'nullable|numeric|min:0',
        ]);

        $chamber->update($request->only(['name', 'address', 'phone', 'working_days', 'start_time', 'end_time', 'fee'])); // Updated fields

        return redirect()->route('doctor.chambers')->with('success', 'Chamber updated successfully!');
    }

    public function destroy(Chamber $chamber)
    {
        // Ensure the chamber belongs to the authenticated doctor
        if ($chamber->doctor->user_id !== auth()->id()) {
            abort(403);
        }

        $chamber->delete();

        return redirect()->route('doctor.chambers')->with('success', 'Chamber deleted successfully!');
    }
}
