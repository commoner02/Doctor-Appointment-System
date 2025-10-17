
@extends('layouts.app')
@section('title', 'Account Pending Verification')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Account Pending Verification</div>
                    <div class="card-body text-center">
                        <h4>Your doctor account is pending verification</h4>
                        <p>Please wait for admin approval or contact support.</p>
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-primary">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection