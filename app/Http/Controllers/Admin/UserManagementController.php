<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ScopedPath;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::with('scopedPath')->paginate(15);
        $scopedPaths = ScopedPath::active()->get();
        
        return view('admin.users.index', compact('users', 'scopedPaths'));
    }

    public function create()
    {
        $scopedPaths = ScopedPath::active()->get();
        return view('admin.users.create', compact('scopedPaths'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'scoped_path_id' => 'nullable|exists:scoped_paths,id',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'scoped_path_id' => $request->scoped_path_id,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        $user->load('scopedPath');
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $scopedPaths = ScopedPath::active()->get();
        return view('admin.users.edit', compact('user', 'scopedPaths'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'scoped_path_id' => 'nullable|exists:scoped_paths,id',
        ]);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'scoped_path_id' => $request->scoped_path_id,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    public function assignPath(Request $request, User $user)
    {
        $request->validate([
            'scoped_path_id' => 'required|exists:scoped_paths,id',
        ]);

        $user->update([
            'scoped_path_id' => $request->scoped_path_id,
        ]);

        return redirect()->back()
            ->with('success', 'User path assignment updated successfully.');
    }

    public function bulkAssign(Request $request)
    {
        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
            'scoped_path_id' => 'required|exists:scoped_paths,id',
        ]);

        User::whereIn('id', $request->user_ids)
            ->update(['scoped_path_id' => $request->scoped_path_id]);

        $count = count($request->user_ids);
        return redirect()->route('admin.users.index')
            ->with('success', "{$count} users assigned to path successfully.");
    }

    public function bulkImport(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
            'scoped_path_id' => 'required|exists:scoped_paths,id',
        ]);

        $file = $request->file('csv_file');
        $csvData = array_map('str_getcsv', file($file->path()));
        $header = array_shift($csvData);

        $imported = 0;
        $errors = [];

        foreach ($csvData as $index => $row) {
            try {
                $data = array_combine($header, $row);
                
                // Skip if email already exists
                if (User::where('email', $data['email'])->exists()) {
                    $errors[] = "Row " . ($index + 2) . ": Email {$data['email']} already exists";
                    continue;
                }
                
                User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password'] ?? 'password123'),
                    'scoped_path_id' => $request->scoped_path_id,
                ]);
                
                $imported++;
            } catch (\Exception $e) {
                $errors[] = "Row " . ($index + 2) . ": " . $e->getMessage();
            }
        }

        $message = "{$imported} users imported successfully.";
        if (!empty($errors)) {
            $message .= " Errors: " . implode(', ', $errors);
        }

        return redirect()->route('admin.users.index')
            ->with('success', $message);
    }
}