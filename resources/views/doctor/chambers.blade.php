@extends('layouts.app')

@section('title', 'My Chambers')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">My Chambers</h1>
                    <p class="text-gray-600">Manage your practice locations</p>
                </div>
                <a href="{{ route('chambers.create') }}"
                    class="px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 font-medium">
                    <i class="fas fa-plus mr-2"></i>Add Chamber
                </a>
            </div>
        </div>

        <!-- Chambers List -->
        <div class="grid md:grid-cols-2 gap-6">
            @forelse($chambers as $chamber)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $chamber->name }}</h3>
                            <div class="flex space-x-2">
                                <form action="{{ route('chambers.destroy', $chamber->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-600 hover:text-red-600"
                                        onclick="return confirm('Are you sure you want to delete this chamber?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        @if($chamber->address)
                            <p class="text-sm text-gray-600 mb-2">
                                <i class="fas fa-map-marker-alt mr-2"></i>{{ $chamber->address }}
                            </p>
                        @endif

                        @if($chamber->phone)
                            <p class="text-sm text-gray-600 mb-2">
                                <i class="fas fa-phone mr-2"></i>{{ $chamber->phone }}
                            </p>
                        @endif

                        @if($chamber->visiting_hours)
                            <p class="text-sm text-gray-600 mb-2">
                                <i class="fas fa-clock mr-2"></i>{{ $chamber->visiting_hours }}
                            </p>
                        @endif

                        @if($chamber->fee)
                            <p class="text-sm font-medium text-gray-900">
                                <i class="fas fa-money-bill mr-2"></i>Fee: ৳{{ number_format($chamber->fee) }}
                            </p>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-2 text-center py-12">
                    <i class="fas fa-clinic-medical text-gray-400 text-4xl mb-4"></i>
                    <p class="text-gray-600 text-lg mb-4">No chambers added yet</p>
                    <a href="{{ route('chambers.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600">
                        <i class="fas fa-plus mr-2"></i>Add Your First Chamber
                    </a>
                </div>
            @endforelse
        </div>
    </div>
@endsection