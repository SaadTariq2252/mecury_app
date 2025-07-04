@extends('admin.layouts.app')

@section('title', 'User Details')
@section('header', 'User Details')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-medium text-gray-900">{{ $user->name }}</h3>
                    <p class="text-sm text-gray-500">{{ $user->email }}</p>
                </div>
                <div class="flex items-center space-x-2">
                    @if($user->scopedPath)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            /{{ $user->scopedPath->path_identifier }}
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            Unassigned
                        </span>
                    @endif
                    <a href="{{ route('admin.users.edit', $user) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fas fa-edit mr-2"></i>Edit
                    </a>
                </div>
            </div>
        </div>

        <div class="px-6 py-4">
            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Full Name</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $user->name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Email Address</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $user->email }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Assigned Path</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        @if($user->scopedPath)
                            <div class="flex items-center">
                                <span class="font-medium">/{{ $user->scopedPath->path_identifier }}</span>
                                <span class="ml-2 text-gray-500">{{ $user->scopedPath->name }}</span>
                            </div>
                        @else
                            <span class="text-gray-400">No path assigned</span>
                        @endif
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Account Status</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Active
                        </span>
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Created</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $user->created_at->format('M d, Y H:i') }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $user->updated_at->format('M d, Y H:i') }}</dd>
                </div>
            </dl>
        </div>

        @if($user->scopedPath)
            <div class="px-6 py-4 border-t border-gray-200">
                <h4 class="text-lg font-medium text-gray-900 mb-4">Access Information</h4>
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <i class="fas fa-link text-blue-600 mr-3"></i>
                        <div>
                            <p class="text-sm font-medium text-blue-900">Login URL</p>
                            <p class="text-sm text-blue-800">
                                <a href="http://127.0.0.1:8000/{{ $user->scopedPath->path_identifier }}/login" target="_blank" class="underline hover:no-underline">
                                    http://127.0.0.1:8000/{{ $user->scopedPath->path_identifier }}/login
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Quick Path Assignment -->
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            <h4 class="text-sm font-medium text-gray-900 mb-3">Quick Path Assignment</h4>
            <form method="POST" action="{{ route('admin.users.assign-path', $user) }}" class="flex items-center space-x-4">
                @csrf
                <select name="scoped_path_id" class="border border-gray-300 rounded px-3 py-2">
                    <option value="">Select Path</option>
                    @foreach(\App\Models\ScopedPath::active()->get() as $path)
                        <option value="{{ $path->id }}" {{ $user->scoped_path_id == $path->id ? 'selected' : '' }}>
                            /{{ $path->path_identifier }} - {{ $path->name }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Update Assignment
                </button>
            </form>
        </div>

        <div class="px-6 py-4 border-t border-gray-200">
            <div class="flex justify-between">
                <a href="{{ route('admin.users.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Users
                </a>
                <div class="space-x-2">
                    <a href="{{ route('admin.users.edit', $user) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fas fa-edit mr-2"></i>Edit User
                    </a>
                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this user?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                            <i class="fas fa-trash mr-2"></i>Delete User
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection