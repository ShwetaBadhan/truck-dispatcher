<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
     public function index(Request $request)
    {
        $query = Role::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%");
        }

        $roles = $query->with('permissions')->latest()->paginate(10);
        $roles->appends(['search' => $request->input('search')]);

       
        $permissions = Permission::all();

        return view('pages.user-management.roles', compact('roles', 'permissions'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'status' => 'required|boolean',
        ]);

        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'web',
            'status' => $request->status,
        ]);

        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,'.$role->id,
            'status' => 'required|boolean',
        ]);

        $role->update([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        return redirect()->route('roles.index')->with('success', 'Role updated successfully!');
    }

    public function destroy(Role $role)
    {
        if (in_array(strtolower($role->name), ['admin', 'super-admin', 'owner'])) {
            return back()->with('error', 'Cannot delete system role.');
        }

        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }

    
    public function getPermissionsModal(Role $role)
    {
        $allPermissions = Permission::orderBy('group_name')
            ->orderBy('name')
            ->get()
            ->groupBy('group_name');
        
        $rolePermissionNames = $role->permissions->pluck('name')->toArray();
        
        return view('pages.user-management.role-permissions-modal', compact('role', 'allPermissions', 'rolePermissionNames'));
    }


    public function updatePermissions(Request $request, Role $role)
    {
        $request->validate([
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name'
        ]);

        $role->syncPermissions($request->permissions ?? []);

        return redirect()->route('roles.index')
            ->with('success', 'Permissions updated successfully for '.$role->name.'!');
    }

    public function assignPermissions(Request $request, Role $role)
    {
        $request->validate([
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $role->syncPermissions($request->input('permissions', []));

        return redirect()->route('roles.index')->with('success', "Permissions assigned to '{$role->name}' successfully!");
    }
}