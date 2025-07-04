@extends('admin.layouts.app')

@section('title', 'Create Scoped Path')
@section('header', 'Create New Scoped Path')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white shadow rounded-lg">
        <form method="POST" action="{{ route('admin.scoped-paths.store') }}" class="space-y-6 p-6">
            @csrf
            
            <div>
                <label for="path_identifier" class="block text-sm font-medium text-gray-700">Path Identifier</label>
                <div class="mt-1 flex rounded-md shadow-sm">
                    <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                        /
                    </span>
                    <input type="text" name="path_identifier" id="path_identifier" value="{{ old('path_identifier') }}" required
                           pattern="[a-z0-9-]+" title="Only lowercase letters, numbers, and hyphens allowed"
                           class="flex-1 block w-full rounded-none rounded-r-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
                           placeholder="pfg">
                </div>
                <p class="mt-1 text-sm text-gray-500">Only lowercase letters, numbers, and hyphens. Example: pfg, example-org</p>
                @error('path_identifier')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Display Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                       placeholder="PFG Group">
                <p class="mt-1 text-sm text-gray-500">Friendly name that will be displayed to users</p>
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <h4 class="text-sm font-medium text-blue-900 mb-2">Preview</h4>
                <p class="text-sm text-blue-800">
                    Users will access this path at: <code class="bg-blue-100 px-2 py-1 rounded">http://yoursite.com/<span id="preview-path">path-identifier</span>/login</code>
                </p>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.scoped-paths.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Cancel
                </a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                    Create Path
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('path_identifier').addEventListener('input', function() {
    document.getElementById('preview-path').textContent = this.value || 'path-identifier';
});
</script>
@endsection