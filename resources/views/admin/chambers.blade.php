@extends('layouts.app')

@section('title', 'Manage Chambers')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Manage Chambers</h1>
                <p class="text-gray-600">Oversee all medical chambers</p>
            </div>
            <div class="text-sm text-gray-500">
                Total Chambers: {{ $chambers->total() }}
            </div>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <form method="GET" class="flex gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Search by chamber name, address, or doctor..."
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
            </div>
            <select name="status" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                <option value="">All Status</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600">
                <i class="fas fa-search mr-2"></i>Search
            </button>
            <a href="{{ route('admin.chambers') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                <i class="fas fa-refresh"></i>
            </a>
        </form>
    </div>

    <!-- Chambers Grid -->
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($chambers as $chamber)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 {{ !$chamber->is_active ? 'opacity-60' : '' }}">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $chamber->name }}</h3>
                        <div class="flex items-center space-x-2">
                            @if($chamber->is_active)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Active
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    Inactive
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Doctor Info -->
                    <div class="mb-4 p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-primary-100 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-user-md text-primary-600 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Dr. {{ $chamber->doctor->user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $chamber->doctor->speciality ?? 'General' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Chamber Details -->
                    <div class="space-y-2 mb-4">
                        <div class="flex items-start">
                            <i class="fas fa-map-marker-alt text-gray-400 mt-1 mr-2 text-sm"></i>
                            <p class="text-sm text-gray-600">{{ Str::limit($chamber->address, 60) }}</p>
                        </div>

                        @if($chamber->phone)
                            <div class="flex items-center">
                                <i class="fas fa-phone text-gray-400 mr-2 text-sm"></i>
                                <p class="text-sm text-gray-600">{{ $chamber->phone }}</p>
                            </div>
                        @endif

                        @if($chamber->visiting_hours)
                            <div class="flex items-center">
                                <i class="fas fa-clock text-gray-400 mr-2 text-sm"></i>
                                <p class="text-sm text-gray-600">{{ $chamber->visiting_hours }}</p>
                            </div>
                        @endif

                        @if($chamber->fee)
                            <div class="flex items-center">
                                <i class="fas fa-money-bill text-gray-400 mr-2 text-sm"></i>
                                <p class="text-sm font-medium text-gray-900">৳{{ number_format($chamber->fee) }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Stats -->
                    <div class="border-t pt-3 mb-4">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Total Appointments:</span>
                            <span class="font-medium text-gray-900">{{ $chamber->appointments_count ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between text-sm mt-1">
                            <span class="text-gray-500">Created:</span>
                            <span class="text-gray-600">{{ $chamber->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex space-x-2">
                        <a href="{{ route('doctor.show', $chamber->doctor->id) }}" 
                           class="flex-1 px-3 py-2 text-center text-sm bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                            View Doctor
                        </a>
                        
                        <form action="{{ route('admin.chambers', $chamber->id) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            @if($chamber->is_active)
                                <button type="submit" class="px-3 py-2 text-sm bg-red-100 text-red-700 rounded-lg hover:bg-red-200" 
                                        onclick="return confirm('Deactivate this chamber?')">
                                    Deactivate
                                </button>
                            @else
                                <button type="submit" class="px-3 py-2 text-sm bg-green-100 text-green-700 rounded-lg hover:bg-green-200">
                                    Activate
                                </button>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <i class="fas fa-clinic-medical text-gray-400 text-4xl mb-4"></i>
                <p class="text-gray-600 text-lg">No chambers found</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($chambers->hasPages())
        <div class="flex justify-center mt-6">
            {{ $chambers->links() }}
        </div>
    @endif
</div>
@endsection