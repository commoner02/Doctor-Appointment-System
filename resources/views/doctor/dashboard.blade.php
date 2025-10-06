@extends('layouts.app')

@section('title', 'Doctor Dashboard')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Welcome, Dr. {{ auth()->user()->name }}</h2>
                <p class="text-muted">Doctor Dashboard</p>

                @if(auth()->user()->doctor)
                    <!-- Quick Stats -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card text-white bg-primary">
                                <div class="card-body">
                                    <h5 class="card-title">Today's Appointments</h5>
                                    <p class="card-text display-6">{{ $todayAppointments->count() ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-white bg-success">
                                <div class="card-body">
                                    <h5 class="card-title">Total Appointments</h5>
                                    <p class="card-text display-6">{{ $totalAppointments ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-white bg-info">
                                <div class="card-body">
                                    <h5 class="card-title">Department</h5>
                                    <p class="card-text">{{ auth()->user()->doctor->department->name ?? 'Not Set' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h5 class="card-title">My Appointments</h5>
                                    <p class="card-text">View and manage appointments</p>
                                    <a href="{{ route('doctor.appointments') }}" class="btn btn-primary">View Appointments</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h5 class="card-title">My Profile</h5>
                                    <p class="card-text">Update your professional information</p>
                                    <a href="#" class="btn btn-outline-primary">Edit Profile</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="alert alert-warning">
                        <h5>Doctor Profile Not Found</h5>
                        <p>Your doctor profile seems to be incomplete. Please contact the administrator.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection