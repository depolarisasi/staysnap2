<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index(){ 
        $permissions = Permission::all();
        return view('permission.index', compact('permissions')); 
    } 
     
    // Store - Save new role
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:permissions,name'
        ]);

        try { 
            $permission = Permission::create(['name' => $request->name]); 

        } catch (\Exception $e) {
            alert()->error('Error', $e->getMessage());
            return redirect()->back();
        }

        alert()->success('Success','Added Successfully');
        return redirect('management/permission');
    }

    // Edit - Show edit form
    public function edit($id)
    {
        $permission = Permission::find($id);
        return view('permission.edit', compact('permission'));
    }

    // Update - Update role
    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|string|unique:permissions,name,' . $permission->id
        ]);
    
        try { 
            $permission->update(['name' => $request->name]);

        } catch (\Exception $e) {
            alert()->error('Error', $e->getMessage());
            return redirect()->back();
        }

        alert()->success('Success','Updated Successfully');
        return redirect('management/permission');
    }

    // Delete role
    public function destroy($id)
    {
        $permission = Permission::find($id);
        $permission->delete();
        
        alert()->success('Success','Deleted Successfully');
        return redirect('management/permission');
    }
}
