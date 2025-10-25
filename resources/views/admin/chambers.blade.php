@extends('layouts.app')

@section('title', 'Manage Chambers')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm p-4">
            <div class="flex items-center justify-between">
                <h1 class="text-xl font-semibold text-gray-900">Chambers</h1>
                <div class="text-sm text-gray-600">{{ $chambers->total() }} total</div>
            </div>
        </div>

        <!-- Chambers Table -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Chamber Name</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Location</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Doctor</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Fee</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($chambers as $chamber)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2">
                                    <div class="text-sm font-medium text-gray-900">{{ $chamber->name }}</div>
                                    <div class="text-xs text-gray-500">+{{ $chamber->phone ?? 'No phone' }}</div>
                                </td>
                                <td class="px-4 py-2">
                                    <div class="text-sm text-gray-700">{{ Str::limit($chamber->address, 50) }}</div>
                                    <div class="text-xs text-gray-500">{{ $chamber->city ?? '' }}</div>
                                    </div>
                                </td>
                                <td class="px-4 py-2 text-sm text-gray-700">{{ $chamber->doctor->user->name }}</td>
                                <td class="px-4 py-2 text-sm text-gray-900">৳{{ number_format($chamber->fee, 2) }}</td>
                                <td class="px-4 py-2">
                                    <span
                                        class="px-2 py-1 text-xs rounded-full
                                            {{ $chamber->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $chamber->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 text-sm">
                                    <form method="POST" action="{{ route('admin.chambers.toggle-status', $chamber->id) }}"
                                        class="inline">
                                        @csrf @method('PATCH')
                                        <button type="submit"
                                            class="text-xs {{ $chamber->is_active ? 'text-red-600 hover:text-red-700' : 'text-green-600 hover:text-green-700' }}">
                                            {{ $chamber->is_active ? 'Deactivate' : 'Activate' }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                                    No chambers found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($chambers->hasPages())
            <div class="flex justify-center mt-4">
                {{ $chambers->links() }}
            </div>
        @endif
    </div>
@endsection