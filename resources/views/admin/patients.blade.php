@extends('layouts.app')

@section('title', 'Manage Patients')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm p-4">
            <div class="flex items-center justify-between">
                <h1 class="text-xl font-semibold text-gray-900">Patients</h1>
                <div class="text-sm text-gray-600">{{ $patients->total() }} total</div>
            </div>
        </div>

        <!-- Patients Table -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Phone</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($patients as $patient)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 text-sm font-medium text-gray-900">{{ $patient->user->name }}</td>
                                <td class="px-4 py-2 text-sm text-gray-700">{{ $patient->user->email }}</td>
                                <td class="px-4 py-2 text-sm text-gray-700">
                                    {{ $patient->phone ?? $patient->user->phone ?? 'N/A' }}</td>
                                <td class="px-4 py-2">
                                    <span
                                        class="px-2 py-1 text-xs rounded-full
                                            {{ ($patient->user->status ?? 'active') === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ ucfirst($patient->user->status ?? 'active') }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 text-sm">
                                    <form method="POST" action="{{ route('admin.patients.toggle-status', $patient->user->id) }}"
                                        class="inline">
                                        @csrf @method('PATCH')
                                        <button type="submit"
                                            class="text-xs {{ ($patient->user->status ?? 'active') === 'active' ? 'text-red-600 hover:text-red-700' : 'text-green-600 hover:text-green-700' }}">
                                            {{ ($patient->user->status ?? 'active') === 'active' ? 'Deactivate' : 'Activate' }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-gray-500">
                                    No patients found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($patients->hasPages())
            <div class="flex justify-center mt-4">
                {{ $patients->links() }}
            </div>
        @endif
    </div>
@endsection