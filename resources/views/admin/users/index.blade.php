@extends('admin.layouts.app')

@section('title', 'Users Management')
@section('header', 'Users Management')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div class="flex space-x-4">
        <a href="{{ route('admin.users.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
            <i class="fas fa-plus mr-2"></i>Create New User
        </a>
        <button onclick="toggleBulkActions()" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            <i class="fas fa-tasks mr-2"></i>Bulk Actions
        </button>
    </div>
    
    <!-- Bulk Import Form -->
    <form method="POST" action="{{ route('admin.users.bulk-import') }}" enctype="multipart/form-data" class="hidden" id="bulk-import-form">
        @csrf
        <div class="flex items-center space-x-2">
            <select name="scoped_path_id" required class="border border-gray-300 rounded px-3 py-2">
                <option value="">Select Path</option>
                @foreach($scopedPaths as $path)
                    <option value="{{ $path->id }}">/{{ $path->path_identifier }} - {{ $path->name }}</option>
                @endforeach
            </select>
            <input type="file" name="csv_file" accept=".csv" required class="border border-gray-300 rounded px-3 py-2">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                Import CSV
            </button>
        </div>
    </form>
</div>

<!-- Bulk Assignment Form -->
<form method="POST" action="{{ route('admin.users.bulk-assign') }}" class="hidden mb-6" id="bulk-assign-form">
    @csrf
    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
        <div class="flex items-center space-x-4">
            <select name="scoped_path_id" required class="border border-gray-300 rounded px-3 py-2">
                <option value="">Assign to Path</option>
                @foreach($scopedPaths as $path)
                    <option value="{{ $path->id }}">/{{ $path->path_identifier }} - {{ $path->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Assign Selected Users
            </button>
            <button type="button" onclick="toggleBulkActions()" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                Cancel
            </button>
        </div>
    </div>
</form>

<div class="bg-white shadow overflow-hidden sm:rounded-md">
    <div class="px-4 py-3 bg-gray-50 border-b border-gray-200">
        <label class="flex items-center">
            <input type="checkbox" id="select-all" class="mr-2">
            <span class="text-sm font-medium text-gray-700">Select All</span>
        </label>
    </div>
    
    <ul class="divide-y divide-gray-200">
        @forelse($users as $user)
            <li>
                <div class="px-4 py-4 flex items-center justify-between">
                    <div class="flex items-center">
                        <input type="checkbox" name="user_ids[]" value="{{ $user->id }}" class="user-checkbox mr-4">
                        <div class="flex-shrink-0">
                            <i class="fas fa-user text-2xl text-blue-500"></i>
                        </div>
                        <div class="ml-4">
                            <div class="flex items-center">
                                <p class="text-lg font-medium text-gray-900">{{ $user->name }}</p>
                                @if($user->scopedPath)
                                    <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        /{{ $user->scopedPath->path_identifier }}
                                    </span>
                                @else
                                    <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        Unassigned
                                    </span>
                                @endif
                            </div>
                            <p class="text-sm text-gray-500">{{ $user->email }}</p>
                            <p class="text-sm text-gray-400">Created: {{ $user->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('admin.users.show', $user) }}" class="text-indigo-600 hover:text-indigo-900">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.users.edit', $user) }}" class="text-yellow-600 hover:text-yellow-900">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this user?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </li>
        @empty
            <li class="px-4 py-8 text-center text-gray-500">
                No users created yet. <a href="{{ route('admin.users.create') }}" class="text-indigo-600 hover:text-indigo-900">Create your first user</a>.
            </li>
        @endforelse
    </ul>
</div>

@if($users->hasPages())
    <div class="mt-6">
        {{ $users->links() }}
    </div>
@endif

<script>
function toggleBulkActions() {
    const bulkForm = document.getElementById('bulk-assign-form');
    const importForm = document.getElementById('bulk-import-form');
    
    bulkForm.classList.toggle('hidden');
    importForm.classList.toggle('hidden');
}

// Select all functionality
document.getElementById('select-all').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.user-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});

// Update bulk assign form with selected users
document.getElementById('bulk-assign-form').addEventListener('submit', function(e) {
    const selectedUsers = document.querySelectorAll('.user-checkbox:checked');
    if (selectedUsers.length === 0) {
        e.preventDefault();
        alert('Please select at least one user.');
        return;
    }
    
    // Add selected user IDs to form
    selectedUsers.forEach(checkbox => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'user_ids[]';
        input.value = checkbox.value;
        this.appendChild(input);
    });
});
</script>
@endsection