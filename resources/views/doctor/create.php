@extends('layouts.app')

@section('title', 'Add Chamber')

@section('content')
<div class="max-w-2xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <a href="{{ route('doctor.chambers') }}"
            class="inline-flex items-center text-primary-600 hover:text-primary-700 mb-4">
            <i class="fas fa-arrow-left mr-2"></i>Back to Chambers
        </a>
        <h1 class="text-2xl font-bold text-gray-900">Add New Chamber</h1>
        <p class="text-gray-600">Add a new practice location</p>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <form action="{{ route('chambers.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Chamber Name *</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                    placeholder="e.g., Main Clinic, City Hospital">
                @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Address *</label>
                <textarea id="address" name="address" rows="3" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                    placeholder="Complete address">{{ old('address') }}</textarea>
                @error('address')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                <input type="text" id="phone" name="phone" value="{{ old('phone') }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                    placeholder="Chamber contact number">
                @error('phone')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="visiting_hours" class="block text-sm font-medium text-gray-700 mb-2">Visiting Hours</label>
                <input type="text" id="visiting_hours" name="visiting_hours" value="{{ old('visiting_hours') }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                    placeholder="e.g., Mon-Fri: 9AM-5PM, Sat: 9AM-2PM">
                @error('visiting_hours')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="fee" class="block text-sm font-medium text-gray-700 mb-2">Consultation Fee (৳)</label>
                <input type="number" id="fee" name="fee" value="{{ old('fee') }}" min="0"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                    placeholder="Consultation fee in Taka">
                @error('fee')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex space-x-4">
                <button type="submit"
                    class="flex-1 px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 font-medium">
                    <i class="fas fa-save mr-2"></i>Save Chamber
                </button>
                <a href="{{ route('doctor.chambers') }}"
                    class="flex-1 px-4 py-2 bg-gray-100 text-gray-700 text-center rounded-lg hover:bg-gray-200 font-medium">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection