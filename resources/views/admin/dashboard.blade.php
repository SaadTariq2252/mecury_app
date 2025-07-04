@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Stats Cards -->
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-route text-2xl text-indigo-600"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Paths</dt>
                        <dd class="text-lg font-medium text-gray-900">{{ $stats['total_paths'] }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-2xl text-green-600"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Active Paths</dt>
                        <dd class="text-lg font-medium text-gray-900">{{ $stats['active_paths'] }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-users text-2xl text-blue-600"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Users</dt>
                        <dd class="text-lg font-medium text-gray-900">{{ $stats['total_users'] }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-user-check text-2xl text-purple-600"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Assigned Users</dt>
                        <dd class="text-lg font-medium text-gray-900">{{ $stats['assigned_users'] }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Recent Paths -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Recent Scoped Paths</h3>
            <div class="space-y-3">
                @forelse($recentPaths as $path)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                        <div>
                            <p class="font-medium text-gray-900">/{{ $path->path_identifier }}</p>
                            <p class="text-sm text-gray-500">{{ $path->name }}</p>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $path->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $path->is_active ? 'Active' : 'Inactive' }}
                            </span>
                            <p class="text-sm text-gray-500 mt-1">{{ $path->users_count }} users</p>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">No scoped paths created yet.</p>
                @endforelse
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.scoped-paths.index') }}" class="text-indigo-600 hover:text-indigo-900 font-medium">
                    View all paths →
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Users -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Recent Users</h3>
            <div class="space-y-3">
                @forelse($recentUsers as $user)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                        <div>
                            <p class="font-medium text-gray-900">{{ $user->name }}</p>
                            <p class="text-sm text-gray-500">{{ $user->email }}</p>
                        </div>
                        <div class="text-right">
                            @if($user->scopedPath)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    /{{ $user->scopedPath->path_identifier }}
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    Unassigned
                                </span>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">No users created yet.</p>
                @endforelse
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.users.index') }}" class="text-indigo-600 hover:text-indigo-900 font-medium">
                    View all users →
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="mt-8 bg-white shadow rounded-lg">
    <div class="px-4 py-5 sm:p-6">
        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Quick Actions</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('admin.scoped-paths.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded text-center">
                <i class="fas fa-plus mr-2"></i>Create New Path
            </a>
            <a href="{{ route('admin.users.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded text-center">
                <i class="fas fa-user-plus mr-2"></i>Add New User
            </a>
            <a href="{{ route('admin.users.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded text-center">
                <i class="fas fa-users mr-2"></i>Manage Users
            </a>
        </div>
    </div>
</div>
@endsection