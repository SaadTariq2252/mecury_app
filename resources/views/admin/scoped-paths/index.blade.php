@extends('admin.layouts.app')

@section('title', 'Scoped Paths')
@section('header', 'Scoped Paths Management')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.scoped-paths.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
        <i class="fas fa-plus mr-2"></i>Create New Path
    </a>
</div>

<div class="bg-white shadow overflow-hidden sm:rounded-md">
    <ul class="divide-y divide-gray-200">
        @forelse($scopedPaths as $path)
            <li>
                <div class="px-4 py-4 flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-route text-2xl {{ $path->is_active ? 'text-green-500' : 'text-red-500' }}"></i>
                        </div>
                        <div class="ml-4">
                            <div class="flex items-center">
                                <p class="text-lg font-medium text-gray-900">/{{ $path->path_identifier }}</p>
                                <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $path->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $path->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-500">{{ $path->name }}</p>
                            <p class="text-sm text-gray-400">{{ $path->users_count }} users assigned</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('admin.scoped-paths.show', $path) }}" class="text-indigo-600 hover:text-indigo-900">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.scoped-paths.edit', $path) }}" class="text-yellow-600 hover:text-yellow-900">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.scoped-paths.toggle', $path) }}" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="text-blue-600 hover:text-blue-900" title="{{ $path->is_active ? 'Deactivate' : 'Activate' }}">
                                <i class="fas fa-{{ $path->is_active ? 'pause' : 'play' }}"></i>
                            </button>
                        </form>
                        @if($path->users_count == 0)
                            <form method="POST" action="{{ route('admin.scoped-paths.destroy', $path) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this path?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </li>
        @empty
            <li class="px-4 py-8 text-center text-gray-500">
                No scoped paths created yet. <a href="{{ route('admin.scoped-paths.create') }}" class="text-indigo-600 hover:text-indigo-900">Create your first path</a>.
            </li>
        @endforelse
    </ul>
</div>
@endsection