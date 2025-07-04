@extends('admin.layouts.app')

@section('title', 'Path Details')
@section('header', 'Scoped Path Details')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-medium text-gray-900">/{{ $scopedPath->path_identifier }}</h3>
                    <p class="text-sm text-gray-500">{{ $scopedPath->name }}</p>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $scopedPath->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $scopedPath->is_active ? 'Active' : 'Inactive' }}
                    </span>
                    <a href="{{ route('admin.scoped-paths.edit', $scopedPath) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                        Edit
                    </a>
                </div>
            </div>
        </div>

        <div class="px-6 py-4">
            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Path Identifier</dt>
                    <dd class="mt-1 text-sm text-gray-900">/{{ $scopedPath->path_identifier }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Display Name</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $scopedPath->name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $scopedPath->is_active ? 'Active' : 'Inactive' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Users Assigned</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $scopedPath->users->count() }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Created</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $scopedPath->created_at->format('M d, Y H:i') }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $scopedPath->updated_at->format('M d, Y H:i') }}</dd>
                </div>
            </dl>
        </div>

        @if($scopedPath->users->count() > 0)
            <div class="px-6 py-4 border-t border-gray-200">
                <h4 class="text-lg font-medium text-gray-900 mb-4">Assigned Users</h4>
                <div class="space-y-3">
                    @foreach($scopedPath->users as $user)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                            <div>
                                <p class="font-medium text-gray-900">{{ $user->name }}</p>
                                <p class="text-sm text-gray-500">{{ $user->email }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-500">Joined: {{ $user->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            <div class="flex justify-between">
                <a href="{{ route('admin.scoped-paths.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to Paths
                </a>
                <div class="space-x-2">
                    <a href="http://127.0.0.1:8000/{{ $scopedPath->path_identifier }}/login" target="_blank" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Test Login Page
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection