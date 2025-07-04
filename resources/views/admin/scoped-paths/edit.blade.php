@extends('admin.layouts.app')

@section('title', 'Edit Scoped Path')
@section('header', 'Edit Scoped Path')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white shadow rounded-lg">
        <form method="POST" action="{{ route('admin.scoped-paths.update', $scopedPath) }}" class="space-y-6 p-6">
            @csrf
            @method('PUT')
            
            <div>
                <label for="path_identifier" class="block text-sm font-medium text-gray-700">Path Identifier</label>
                <div class="mt-1 flex rounded-md shadow-sm">
                    <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                        /
                    </span>
                    <input type="text" name="path_identifier" id="path_identifier" value="{{ old('path_identifier', $scopedPath->path_identifier) }}" required
                           pattern="[a-z0-9-]+" title="Only lowercase letters, numbers, and hyphens allowed"
                           class="flex-1 block w-full rounded-none rounded-r-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <p class="mt-1 text-sm text-gray-500">Only lowercase letters, numbers, and hyphens</p>
                @error('path_identifier')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Display Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $scopedPath->name) }}" required
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $scopedPath->is_active) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <span class="ml-2 text-sm text-gray-700">Active</span>
                </label>
                <p class="mt-1 text-sm text-gray-500">Inactive paths cannot be accessed by users</p>
            </div>

            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <h4 class="text-sm font-medium text-yellow-900 mb-2">⚠️ Warning</h4>
                <p class="text-sm text-yellow-800">
                    Changing the path identifier will affect all users assigned to this path. 
                    Make sure to update any bookmarks or saved URLs.
                </p>
            </div>

            @if($scopedPath->users->count() > 0)
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <h4 class="text-sm font-medium text-blue-900 mb-2">Assigned Users ({{ $scopedPath->users->count() }})</h4>
                    <div class="text-sm text-blue-800">
                        @foreach($scopedPath->users->take(5) as $user)
                            <span class="inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs mr-2 mb-1">
                                {{ $user->name }}
                            </span>
                        @endforeach
                        @if($scopedPath->users->count() > 5)
                            <span class="text-blue-600">and {{ $scopedPath->users->count() - 5 }} more...</span>
                        @endif
                    </div>
                </div>
            @endif

            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.scoped-paths.show', $scopedPath) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Cancel
                </a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                    Update Path
                </button>
            </div>
        </form>
    </div>
</div>
@endsection