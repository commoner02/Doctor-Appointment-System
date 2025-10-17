
@extends('layouts.app')

@section('title', 'Manage Doctors')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Manage Doctors</h2>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Speciality</th>
                            <th>Experience</th>
                            <th>Qualification</th>
                            <th>Verified</th>
                            <th>Chambers</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($doctors as $doctor)
                            <tr>
                                <td>{{ $doctor->id }}</td>
                                <td>{{ $doctor->first_name }} {{ $doctor->last_name }}</td>
                                <td>{{ $doctor->user->email }}</td>
                                <td>{{ $doctor->speciality }}</td>
                                <td>{{ $doctor->experience_years }} years</td>
                                <td>{{ $doctor->qualification }}</td>
                                <td>
                                    @if($doctor->user->is_verified)
                                        <span class="badge bg-success">Verified</span>
                                    @else
                                        <span class="badge bg-warning">Pending</span>
                                        <form action="{{ route('admin.verify-doctor', $doctor->user) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success ms-1">Verify</button>
                                        </form>
                                    @endif
                                </td>
                                <td>{{ $doctor->chambers->count() }}</td>
                                <td>
                                    <a href="{{ route('admin.doctors.show', $doctor) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">No doctors found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{ $doctors->links() }}
        </div>
    </div>
</div>
@endsection