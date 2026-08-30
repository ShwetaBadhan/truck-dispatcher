<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display listing of users
     */
    public function index(Request $request)
    {
        $query = User::query();

        // 1. Search Logic
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // 2. Pagination (10 users per page) & Eager load roles
        $users = $query->with('roles')->latest()->paginate(10);
        
        // Keep search term in pagination links (e.g. ?search=john&page=2)
        $users->appends(['search' => $request->input('search')]);
$roles = Role::all();
        // Return view (Make sure the view path matches your file location)
        return view('pages.user-management.users', compact('users','roles')); 
    }

    /**
     * Store newly created user
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|exists:roles,name',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|min:8|confirmed',
            'status' => 'nullable|in:0,1',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:800'
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'status' => $request->status ?? 1
        ];

        // ✅ Handle profile photo
        if ($request->hasFile('profile_photo')) {
            $data['profile_photo'] = $request->file('profile_photo')->store('profile-photos', 'public');
        }

        $user = User::create($data);
        $user->assignRole($request->role);

        return redirect()->route('users.index')->with('success', 'User created successfully!');
    }

    /**
     * Update existing user
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'role' => 'required|exists:roles,name',
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|min:8|confirmed',
            'status' => 'nullable|in:0,1',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:800'
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'status' => $request->status ?? 1
        ];

        // Update password only if provided
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // ✅ Handle profile photo
        if ($request->hasFile('profile_photo')) {
            // Delete old photo
            if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
                Storage::disk('public')->delete($user->profile_photo);
            }
            
            // Store new photo
            $data['profile_photo'] = $request->file('profile_photo')->store('profile-photos', 'public');
        }

        $user->update($data);
        $user->syncRoles([$request->role]);

        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }

    /**
     * Remove user
     */
    public function destroy(User $user)
    {
        // Delete profile photo from storage
        if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
            Storage::disk('public')->delete($user->profile_photo);
        }
        
        $user->delete();
        
        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }
}