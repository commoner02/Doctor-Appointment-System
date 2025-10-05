@extends('layouts.app')

@section('title', 'Browse Doctors')

@section('content')
<div class="container">
    <h2>Find a Doctor</h2>
    
    <!-- Departments Filter -->
    <div class="card mb-4">
        <div class="card-header">
            <h5>Filter by Department</h5>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach($departments as $department)
                <div class="col-md-3 mb-2">
                    <a href="#dept-{{ $department->id }}" class="btn btn-outline-primary btn-sm">
                        {{ $department->name }} ({{ $department->doctors->count() }})
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Doctors List -->
    <div class="row">
        @foreach($doctors as $doctor)
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h5 class="card-title">Dr. {{ $doctor->first_name }} {{ $doctor->last_name }}</h5>
                            <p class="card-text">
                                <strong>Specialty:</strong> {{ $doctor->specialty }}<br>
                                <strong>Department:</strong> {{ $doctor->department->name }}<br>
                                <strong>Phone:</strong> {{ $doctor->phone }}
                            </p>
                            <a href="{{ route('doctors.show', $doctor->id) }}" class="btn btn-primary">View Profile & Book</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection