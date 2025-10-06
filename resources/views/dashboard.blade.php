@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body">
                    <h4>Welcome, {{ auth()->user()->name }}!</h4>
                    <p>You are logged in as: <strong>{{ ucfirst(auth()->user()->role) }}</strong></p>
                    
                    @if(auth()->user()->role === 'patient')
                        <a href="{{ route('patient.dashboard') }}" class="btn btn-primary">Go to Patient Dashboard</a>
                    @elseif(auth()->user()->role === 'doctor')
                        <a href="{{ route('doctor.dashboard') }}" class="btn btn-primary">Go to Doctor Dashboard</a>
                    @elseif(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Go to Admin Dashboard</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection