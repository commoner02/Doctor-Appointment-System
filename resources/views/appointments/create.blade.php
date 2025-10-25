@extends('layouts.app')

@section('title', 'Book Appointment')

@section('content')
    <div class="max-w-xl mx-auto space-y-4">
        <div class="bg-white shadow-sm p-4 border border-gray-200">
            <h1 class="text-xl font-semibold mb-3">Book with Dr. {{ $doctor->user->name }}</h1>

            <form method="POST" action="{{ route('appointments.store', $doctor) }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium mb-1">Select Chamber</label>
                    <select name="chamber_id" required class="w-full px-3 py-2 border border-gray-300">
                        <option value="">Choose chamber</option>
                        @foreach($chambers as $chamber)
                            <option value="{{ $chamber->id }}">
                                {{ $chamber->name }} — {{ $chamber->address }}
                                ({{ $chamber->start_time }} - {{ $chamber->end_time }})
                                @if($chamber->fee) - Fee: {{ number_format($chamber->fee, 2) }} @endif
                            </option>
                        @endforeach
                    </select>
                    @error('chamber_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Appointment Date</label>
                    <input type="date" name="appointment_date" required min="{{ now()->toDateString() }}"
                        class="w-full px-3 py-2 border border-gray-300">
                    @error('appointment_date') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Reason for Visit</label>
                    <textarea name="reason" rows="3" required class="w-full px-3 py-2 border border-gray-300"
                        placeholder="Brief reason or symptoms"></textarea>
                    @error('reason') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <button type="submit" class="w-full px-3 py-2 bg-primary-500 text-white">Book Appointment</button>
            </form>
        </div>
    </div>
@endsection