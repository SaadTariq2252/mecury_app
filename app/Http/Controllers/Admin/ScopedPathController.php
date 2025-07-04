<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ScopedPath;

class ScopedPathController extends Controller
{
    public function index()
    {
        $scopedPaths = ScopedPath::withCount('users')->get();
        return view('admin.scoped-paths.index', compact('scopedPaths'));
    }

    public function create()
    {
        return view('admin.scoped-paths.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'path_identifier' => 'required|string|max:50|unique:scoped_paths|regex:/^[a-z0-9-]+$/',
            'name' => 'required|string|max:100',
        ]);

        ScopedPath::create([
            'path_identifier' => $request->path_identifier,
            'name' => $request->name,
            'is_active' => true,
        ]);

        return redirect()->route('admin.scoped-paths.index')
            ->with('success', 'Scoped path created successfully.');
    }

    public function show(ScopedPath $scopedPath)
    {
        $scopedPath->load('users');
        return view('admin.scoped-paths.show', compact('scopedPath'));
    }

    public function edit(ScopedPath $scopedPath)
    {
        return view('admin.scoped-paths.edit', compact('scopedPath'));
    }

    public function update(Request $request, ScopedPath $scopedPath)
    {
        $request->validate([
            'path_identifier' => 'required|string|max:50|unique:scoped_paths,path_identifier,' . $scopedPath->id . '|regex:/^[a-z0-9-]+$/',
            'name' => 'required|string|max:100',
            'is_active' => 'boolean',
        ]);

        $scopedPath->update([
            'path_identifier' => $request->path_identifier,
            'name' => $request->name,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.scoped-paths.index')
            ->with('success', 'Scoped path updated successfully.');
    }

    public function destroy(ScopedPath $scopedPath)
    {
        // Check if path has users assigned
        if ($scopedPath->users()->count() > 0) {
            return redirect()->route('admin.scoped-paths.index')
                ->with('error', 'Cannot delete path with assigned users. Please reassign users first.');
        }

        $scopedPath->delete();

        return redirect()->route('admin.scoped-paths.index')
            ->with('success', 'Scoped path deleted successfully.');
    }

    public function toggle(ScopedPath $scopedPath)
    {
        $scopedPath->update(['is_active' => !$scopedPath->is_active]);

        $status = $scopedPath->is_active ? 'activated' : 'deactivated';
        return redirect()->route('admin.scoped-paths.index')
            ->with('success', "Scoped path {$status} successfully.");
    }
}