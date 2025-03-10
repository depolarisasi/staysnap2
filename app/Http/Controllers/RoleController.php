<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Branch;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index(){
        $roles = Role::with('permissions')->get();
        $permission_list = Permission::all();
        return view('roles.index', compact('roles','permission_list')); 
    } 
     
    // Store - Save new role
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:roles,name',
            'permissions' => 'array',
        ]);

        if($validated){
            try { 
                $role = Role::create(['name' => $validated['name']]);
                $role->syncPermissions($validated['permissions'] ?? []);
    
            } catch (\Exception $e) {
                alert()->error('Error', $e->getMessage());
                return redirect()->back();
            }
            
        alert()->success('Success','Added Successfully');
        return redirect('management/role');
        } else {
            alert()->error('Error', 'Validation failed');
                return redirect()->back();
        }
        

    }

    // Edit - Show edit form
    public function edit($id)
    {
        $role = Role::with('permissions')->find($id);
        $permission_list = Permission::all();
        
        $rolePermissions = $role->permissions->pluck('name')->toArray();
        return view('roles.edit', compact('role', 'permission_list','rolePermissions'));
    }

    // Update - Update role
    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:roles,name,' . $role->id,
            'permissions' => 'array',
        ]);

        try {  
            $role->update(['name' => $validated['name']]);
            $role->syncPermissions($validated['permissions'] ?? []);
        } catch (\Exception $e) {
            alert()->error('Error','Update Successfully');
            return redirect()->back();
        }
 
        alert()->success('Success','Update Successfully');
        return redirect('management/role');
    }

    // Delete role
    public function destroy($id)
    {
        $role = Role::find($id);
        try { 
            $role->delete(); 
        } catch (\Exception $e) {
            alert()->error('Error', $e->getMessage());
            return redirect()->back();
        }
        alert()->success('Success','Deleted Successfully');
        return redirect('management/role');
    }
}
