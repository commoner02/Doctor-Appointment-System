@extends('layouts.app')

@section('title', 'Profile')

@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">Profile Settings</h1>
            <p class="page-subtitle">Manage your account settings and personal information</p>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <!-- Profile Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-user me-2"></i>Profile Information</h5>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('profile.update') }}">
                            @csrf
                            @method('patch')

                            @if (session('status') === 'profile-updated')
                                <div class="alert alert-success">
                                    Profile updated successfully!
                                </div>
                            @endif

                            <!-- Basic Information -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                        name="name" value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                        name="email" value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="first_name" class="form-label">First Name</label>
                                    <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                        id="first_name" name="first_name"
                                        value="{{ old('first_name', $user->isPatient() ? $user->patient->first_name : ($user->isDoctor() ? $user->doctor->first_name : '')) }}"
                                        required>
                                    @error('first_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="last_name" class="form-label">Last Name</label>
                                    <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                        id="last_name" name="last_name"
                                        value="{{ old('last_name', $user->isPatient() ? $user->patient->last_name : ($user->isDoctor() ? $user->doctor->last_name : '')) }}"
                                        required>
                                    @error('last_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                                        name="phone"
                                        value="{{ old('phone', $user->isPatient() ? $user->patient->phone : ($user->isDoctor() ? $user->doctor->phone : '')) }}"
                                        required>
                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Patient Specific Fields -->
                            @if($user->isPatient())
                                <hr class="my-4">
                                <h6 class="mb-3"><i class="fas fa-heartbeat me-2"></i>Patient Information</h6>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="gender" class="form-label">Gender</label>
                                        <select class="form-control @error('gender') is-invalid @enderror" id="gender"
                                            name="gender" required>
                                            <option value="">Select Gender</option>
                                            <option value="Male" {{ old('gender', $user->patient->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                            <option value="Female" {{ old('gender', $user->patient->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                            <option value="Other" {{ old('gender', $user->patient->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                        @error('gender')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="date_of_birth" class="form-label">Date of Birth</label>
                                        <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror"
                                            id="date_of_birth" name="date_of_birth"
                                            value="{{ old('date_of_birth', $user->patient->date_of_birth) }}" required>
                                        @error('date_of_birth')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="blood_group" class="form-label">Blood Group</label>
                                        <select class="form-control @error('blood_group') is-invalid @enderror" id="blood_group"
                                            name="blood_group" required>
                                            <option value="">Select Blood Group</option>
                                            <option value="A+" {{ old('blood_group', $user->patient->blood_group) == 'A+' ? 'selected' : '' }}>A+</option>
                                            <option value="A-" {{ old('blood_group', $user->patient->blood_group) == 'A-' ? 'selected' : '' }}>A-</option>
                                            <option value="B+" {{ old('blood_group', $user->patient->blood_group) == 'B+' ? 'selected' : '' }}>B+</option>
                                            <option value="B-" {{ old('blood_group', $user->patient->blood_group) == 'B-' ? 'selected' : '' }}>B-</option>
                                            <option value="AB+" {{ old('blood_group', $user->patient->blood_group) == 'AB+' ? 'selected' : '' }}>AB+</option>
                                            <option value="AB-" {{ old('blood_group', $user->patient->blood_group) == 'AB-' ? 'selected' : '' }}>AB-</option>
                                            <option value="O+" {{ old('blood_group', $user->patient->blood_group) == 'O+' ? 'selected' : '' }}>O+</option>
                                            <option value="O-" {{ old('blood_group', $user->patient->blood_group) == 'O-' ? 'selected' : '' }}>O-</option>
                                        </select>
                                        @error('blood_group')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label for="address" class="form-label">Address</label>
                                        <textarea class="form-control @error('address') is-invalid @enderror" id="address"
                                            name="address" rows="3"
                                            required>{{ old('address', $user->patient->address) }}</textarea>
                                        @error('address')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            @endif

                            <!-- Doctor Specific Fields -->
                            @if($user->isDoctor())
                                <hr class="my-4">
                                <h6 class="mb-3"><i class="fas fa-stethoscope me-2"></i>Doctor Information</h6>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="speciality" class="form-label">Speciality</label>
                                        <input type="text" class="form-control @error('speciality') is-invalid @enderror"
                                            id="speciality" name="speciality"
                                            value="{{ old('speciality', $user->doctor->speciality) }}" required>
                                        @error('speciality')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="license_no" class="form-label">License Number</label>
                                        <input type="text" class="form-control @error('license_no') is-invalid @enderror"
                                            id="license_no" name="license_no"
                                            value="{{ old('license_no', $user->doctor->license_no) }}" required>
                                        @error('license_no')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label for="qualifications" class="form-label">Qualifications</label>
                                        <textarea class="form-control @error('qualifications') is-invalid @enderror"
                                            id="qualifications" name="qualifications" rows="3"
                                            required>{{ old('qualifications', $user->doctor->qualifications) }}</textarea>
                                        @error('qualifications')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            @endif

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i>Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Update Password -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-lock me-2"></i>Update Password</h5>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('password.update') }}">
                            @csrf
                            @method('put')

                            @if (session('status') === 'password-updated')
                                <div class="alert alert-success">
                                    Password updated successfully!
                                </div>
                            @endif

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="current_password" class="form-label">Current Password</label>
                                    <input type="password"
                                        class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                                        id="current_password" name="current_password" required>
                                    @error('current_password', 'updatePassword')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="password" class="form-label">New Password</label>
                                    <input type="password"
                                        class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                                        id="password" name="password" required>
                                    @error('password', 'updatePassword')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                    <input type="password" class="form-control" id="password_confirmation"
                                        name="password_confirmation" required>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-key me-1"></i>Update Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Delete Account -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 text-danger"><i class="fas fa-exclamation-triangle me-2"></i>Delete Account</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">Once your account is deleted, all of its resources and data will be
                            permanently deleted. Before deleting your account, please download any data or information that
                            you wish to retain.</p>

                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                            data-bs-target="#confirmUserDeletion">
                            <i class="fas fa-trash me-1"></i>Delete Account
                        </button>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Account Info -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Account Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar-circle me-3"
                                style="width: 60px; height: 60px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; font-size: 1.5rem;">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <div>
                                <h6 class="mb-1">{{ $user->name }}</h6>
                                <span class="badge bg-primary">{{ ucfirst($user->role) }}</span>
                            </div>
                        </div>

                        <div class="info-item d-flex justify-content-between mb-2">
                            <span class="text-muted">Email</span>
                            <small>{{ $user->email }}</small>
                        </div>
                        <div class="info-item d-flex justify-content-between mb-2">
                            <span class="text-muted">Status</span>
                            <span class="badge {{ $user->is_verified ? 'bg-success' : 'bg-warning' }}">
                                {{ $user->is_verified ? 'Verified' : 'Pending' }}
                            </span>
                        </div>
                        <div class="info-item d-flex justify-content-between">
                            <span class="text-muted">Member Since</span>
                            <small>{{ $user->created_at->format('M Y') }}</small>
                        </div>
                    </div>
                </div>

                @if($user->isDoctor())
                    <!-- Quick Actions for Doctors -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-bolt me-2"></i>Quick Actions</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('doctor.chambers') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-building me-1"></i>Manage Chambers
                                </a>
                                <a href="{{ route('doctor.appointments') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-calendar-alt me-1"></i>View Appointments
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Delete Account Modal -->
    <div class="modal fade" id="confirmUserDeletion" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete your account? Once your account is deleted, all of its resources and
                        data will be permanently deleted. Please enter your password to confirm you would like to
                        permanently delete your account.</p>

                    <form method="post" action="{{ route('profile.destroy') }}">
                        @csrf
                        @method('delete')

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password"
                                class="form-control @error('password', 'userDeletion') is-invalid @enderror" id="password"
                                name="password" placeholder="Password" required>
                            @error('password', 'userDeletion')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">Delete Account</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .avatar-circle {
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        .info-item {
            padding-bottom: 0.75rem;
            border-bottom: 1px solid #f1f5f9;
        }

        .info-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }
    </style>
@endsection