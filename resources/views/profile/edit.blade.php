@extends('layouts.app')

@section('title', 'Profile')

@section('content')
    <div class="container">
        <div class="card mb-3">
            <div class="card-header">Profile</div>
            <div class="card-body">
                <form method="post" action="{{ route('profile.update') }}" id="profile-form">
                    @csrf
                    @method('patch')

                    @if (session('status') === 'profile-updated')
                        <div class="alert alert-success">Profile updated successfully!</div>
                    @endif

                    <input type="hidden" name="name" id="name" value="{{ old('name', $user->name) }}">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">First Name</label>
                            <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                name="first_name"
                                value="{{ old('first_name', $user->isPatient() ? $user->patient->first_name : ($user->isDoctor() ? $user->doctor->first_name : '')) }}"
                                required>
                            @error('first_name')<span
                            class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Last Name</label>
                            <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                name="last_name"
                                value="{{ old('last_name', $user->isPatient() ? $user->patient->last_name : ($user->isDoctor() ? $user->doctor->last_name : '')) }}"
                                required>
                            @error('last_name')<span
                            class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email', $user->email) }}" required>
                            @error('email')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone"
                                value="{{ old('phone', $user->isPatient() ? $user->patient->phone : ($user->isDoctor() ? $user->doctor->phone : '')) }}"
                                required>
                            @error('phone')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
                <script>
                    document.getElementById('profile-form').addEventListener('submit', function () {
                        const form = this;
                        const first = form.querySelector('input[name="first_name"]').value.trim();
                        const last = form.querySelector('input[name="last_name"]').value.trim();
                        document.getElementById('name').value = [first, last].filter(Boolean).join(' ');
                    });
                </script>
            </div>
        </div>
    </div>
@endsection