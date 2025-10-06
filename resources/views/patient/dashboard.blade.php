@extends('layouts.app')

@section('title', 'Patient Dashboard')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Welcome, {{ auth()->user()->name }}</h2>
                <p class="text-muted">Patient Dashboard</p>

                @if(auth()->user()->patient)
                    <!-- Quick Stats -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card text-white bg-primary">
                                <div class="card-body">
                                    <h5 class="card-title">My Appointments</h5>
                                    <p class="card-text display-4">{{ $myAppointments->count() ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Find Doctors</h5>
                                    <p class="card-text">Browse available doctors and book appointments</p>
                                    <a href="{{ route('doctors.browse') }}" class="btn btn-primary">Browse Doctors</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h5 class="card-title">My Appointments</h5>
                                    <p class="card-text">View your scheduled appointments</p>
                                    <a href="{{ route('appointments.my') }}" class="btn btn-outline-primary">View Appointments</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="alert alert-warning">
                        <h5>Patient Profile Not Found</h5>
                        <p>Your patient profile seems to be incomplete. Please contact the administrator.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection