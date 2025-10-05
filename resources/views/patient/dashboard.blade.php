@extends('layouts.app')

@section('title', 'Patient Dashboard')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Welcome, {{ auth()->user()->name }}</h2>
                <p class="text-muted">Patient Dashboard</p>

                <!-- Quick Stats -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card text-white bg-primary">
                            <div class="card-body">
                                <h5 class="card-title">My Appointments</h5>
                                <p class="card-text display-4">
                                    @if(isset($myAppointments))
                                        {{ $myAppointments->count() }}
                                    @else
                                        0
                                    @endif
                                </p>
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
                                <a href="#" class="btn btn-primary">Browse Doctors</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body text-center">
                                <h5 class="card-title">My Profile</h5>
                                <p class="card-text">Update your personal information</p>
                                <a href="#" class="btn btn-outline-primary">Edit Profile</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection