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
        $user = auth()->user();

        if (!$user->isDoctor() || !$user->is_verified) {
            abort(403, 'Unauthorized');
        }

        return view('chambers.create');
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        if (!$user->isDoctor() || !$user->is_verified) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'chamber_name' => 'required|string|max:255',
            'chamber_location' => 'required|string|max:500',
            'phone' => 'required|string|max:20',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'visiting_fee' => 'required|numeric|min:0',
            'working_days' => 'required|array|min:1',
            'working_days.*' => 'in:Saturday,Sunday,Monday,Tuesday,Wednesday,Thursday,Friday'
        ]);

        $doctor = $user->doctor;

        // Convert array to comma-separated string
        $workingDaysString = is_array($validated['working_days'])
            ? implode(',', $validated['working_days'])
            : $validated['working_days'];

        Chamber::create([
            'doctor_id' => $doctor->id,
            'chamber_name' => $validated['chamber_name'],
            'chamber_location' => $validated['chamber_location'],
            'phone' => $validated['phone'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'visiting_fee' => $validated['visiting_fee'],
            'working_days' => $workingDaysString
        ]);

        return redirect()->route('doctor.chambers')->with('success', 'Chamber added successfully!');
    }

    public function edit(Chamber $chamber)
    {
        $user = auth()->user();

        if (!$user->isDoctor() || !$user->is_verified || $chamber->doctor_id !== $user->doctor->id) {
            abort(403, 'Unauthorized');
        }

        return view('chambers.edit', compact('chamber'));
    }

    public function update(Request $request, Chamber $chamber)
    {
        $user = auth()->user();

        if (!$user->isDoctor() || !$user->is_verified || $chamber->doctor_id !== $user->doctor->id) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'chamber_name' => 'required|string|max:255',
            'chamber_location' => 'required|string|max:500',
            'phone' => 'required|string|max:20',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'visiting_fee' => 'required|numeric|min:0',
            'working_days' => 'required|array|min:1',
            'working_days.*' => 'in:Saturday,Sunday,Monday,Tuesday,Wednesday,Thursday,Friday'
        ]);

        // Convert array to comma-separated string
        $workingDaysString = is_array($validated['working_days'])
            ? implode(',', $validated['working_days'])
            : $validated['working_days'];

        $chamber->update([
            'chamber_name' => $validated['chamber_name'],
            'chamber_location' => $validated['chamber_location'],
            'phone' => $validated['phone'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'visiting_fee' => $validated['visiting_fee'],
            'working_days' => $workingDaysString
        ]);

        return redirect()->route('doctor.chambers')->with('success', 'Chamber updated successfully!');
    }

    public function destroy(Chamber $chamber)
    {
        $user = auth()->user();

        if (!$user->isDoctor() || !$user->is_verified || $chamber->doctor_id !== $user->doctor->id) {
            abort(403, 'Unauthorized');
        }

        $chamber->delete();

        return redirect()->route('doctor.chambers')->with('success', 'Chamber deleted successfully!');
    }
}
