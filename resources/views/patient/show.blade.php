@extends('layouts.app')

@section('title', 'Patient Profile')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Patient Profile</div>
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-md-6"><strong>Name:</strong> {{ $patient->first_name }} {{ $patient->last_name }}</div>
                <div class="col-md-6"><strong>Email:</strong> {{ $patient->user->email ?? '-' }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-6"><strong>Phone:</strong> {{ $patient->phone ?? '-' }}</div>
                <div class="col-md-6"><strong>Gender:</strong> {{ $patient->gender ?? '-' }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-6"><strong>DOB:</strong> {{ $patient->date_of_birth ?? '-' }}</div>
                <div class="col-md-6"><strong>Blood Group:</strong> {{ $patient->blood_group ?? '-' }}</div>
            </div>
            <div class="mb-2"><strong>Address:</strong> {{ $patient->address ?? '-' }}</div>
        </div>
    </div>
</div>
@endsection