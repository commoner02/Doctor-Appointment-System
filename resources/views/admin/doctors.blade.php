
@extends('layouts.app')

@section('title', 'Manage Doctors')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm p-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-semibold text-gray-900">Doctors</h1>
            <div class="text-sm text-gray-600">{{ $doctors->total() }} total</div>
        </div>
    </div>

    <!-- Doctors Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Speciality</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Chambers</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($doctors as $doctor)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 text-sm font-medium text-gray-900">{{ $doctor->user->name }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $doctor->speciality ?? 'General' }}</td>
                            <td class="px-4 py-2">
                                <span class="px-2 py-1 text-xs rounded-full
                                    {{ $doctor->verification_status === 'verified' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $doctor->verification_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $doctor->verification_status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ ucfirst($doctor->verification_status ?? 'pending') }}
                                </span>
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-900">{{ $doctor->chambers->count() }}</td>
                            <td class="px-4 py-2 text-sm">
                                @if($doctor->verification_status === 'pending')
                                    <form method="POST" action="{{ route('admin.doctors.verify', $doctor->id) }}" class="inline mr-2">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="text-xs text-green-600 hover:text-green-700">Verify</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.doctors.reject', $doctor->id) }}" class="inline">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="text-xs text-red-600 hover:text-red-700">Reject</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-gray-500">
                                No doctors found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($doctors->hasPages())
        <div class="flex justify-center mt-4">
            {{ $doctors->links() }}
        </div>
    @endif
</div>
@endsection