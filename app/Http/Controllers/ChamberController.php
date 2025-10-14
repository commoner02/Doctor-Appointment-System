<?php

namespace App\Http\Controllers;

use App\Models\Chamber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChamberController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if (!$user->isDoctor() || !$user->is_verified) {
            abort(403, 'Unauthorized');
        }
        
        $chambers = Chamber::where('doctor_id', $user->doctor->id)->get();
        
        return view('doctor.chambers', compact('chambers'));
    }

    public function create()
    {
        $user = auth()->user();
        
        if (!$user->isDoctor() || !$user->is_verified) {
            abort(403, 'Unauthorized');
        }
        
        return view('doctor.chamber-create');
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        
        if (!$user->isDoctor() || !$user->is_verified) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'chamber_name' => ['required', 'string', 'max:100'],
            'chamber_location' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'working_days' => ['required', 'array', 'min:1'],
            'working_days.*' => ['in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday'],
        ]);

        try {
            DB::beginTransaction();

            Chamber::create([
                'doctor_id' => $user->doctor->id,
                'chamber_name' => $request->chamber_name,
                'chamber_location' => $request->chamber_location,
                'phone' => $request->phone,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'working_days' => implode(',', $request->working_days),
            ]);

            DB::commit();

            return redirect()->route('doctor.chambers')->with('success', 'Chamber added successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => 'Failed to add chamber. Please try again.'])->withInput();
        }
    }

    public function edit(Chamber $chamber)
    {
        $user = auth()->user();
        
        if (!$user->isDoctor() || !$user->is_verified || $chamber->doctor_id !== $user->doctor->id) {
            abort(403, 'Unauthorized');
        }
        
        return view('doctor.chamber-edit', compact('chamber'));
    }

    public function update(Request $request, Chamber $chamber)
    {
        $user = auth()->user();
        
        if (!$user->isDoctor() || !$user->is_verified || $chamber->doctor_id !== $user->doctor->id) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'chamber_name' => ['required', 'string', 'max:100'],
            'chamber_location' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'working_days' => ['required', 'array', 'min:1'],
            'working_days.*' => ['in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday'],
        ]);

        try {
            DB::beginTransaction();

            $chamber->update([
                'chamber_name' => $request->chamber_name,
                'chamber_location' => $request->chamber_location,
                'phone' => $request->phone,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'working_days' => implode(',', $request->working_days),
            ]);

            DB::commit();

            return redirect()->route('doctor.chambers')->with('success', 'Chamber updated successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => 'Failed to update chamber. Please try again.'])->withInput();
        }
    }

    public function destroy(Chamber $chamber)
    {
        $user = auth()->user();
        
        if (!$user->isDoctor() || !$user->is_verified || $chamber->doctor_id !== $user->doctor->id) {
            abort(403, 'Unauthorized');
        }

        try {
            $chamber->delete();
            return redirect()->route('doctor.chambers')->with('success', 'Chamber deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to delete chamber. Please try again.']);
        }
    }
}
