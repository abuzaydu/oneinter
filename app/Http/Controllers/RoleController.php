<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::withCount('users')->withCount('permissions')->paginate(10);
        // return $roles;
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->can('create_roles')) {
            abort(403, 'Unauthorized action.');
        }
        
        $currPermissions = array();
        $permissions = Permission::select('id', 'name')->get();
        return view('admin.roles.create', compact('permissions', 'currPermissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $role = Role::where('name', $request['name'])->first();
        if (is_null($role)) {
            if (is_array($request['permission']) || is_object($request['permission'])) {

                $role = new Role();
                $role->name = $request['name'];
                $role->description = $request['description'];
                $role->save();
                foreach ($request['permission'] as $perm) {
                    $role->givePermissionTo($perm);
                }
                return redirect('admin/roles')->with('success', 'Role Permissions updated successfully');
            }else{
                return redirect()->back()->with('info', 'No Permissions selected. Please select at least one permission');
            }
        }else {
            return redirect()->back()->with('error', 'Role with same name already exists');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $page = 'Edit Role';
        $role = Role::find(decrypt($id));

        $currPermissions = $role->permissions()->pluck('permission_id')->toArray();
        $permissions = Permission::select('id', 'name')->get();
        return view('admin.roles.edit', compact('page', 'role', 'permissions', 'currPermissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $role = Role::find(decrypt($id));
        $roleexist = Role::where('name', $request['name'])->where('id', '!=', $role->id)->first();
        if (!is_null($roleexist)) {
            return redirect()->back()->with('info', 'Role with same name already exists');
        }else{
            $role->name = $request['name'];
            $role->description = $request['description'];
            $role->save();

            if (is_array($request['permission']) || is_object($request['permission'])) {
                $role->syncPermissions($request['permission']);
                
                return redirect('admin/roles')->with('success', 'Role Permissions updated successfully');
            }else{
                return redirect()->back()->with('info', 'No Permissions selected');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::find(decrypt($id));
        if (!is_null($role)) {
            $users = User::role($role->name)->count();
            if ($users == 0) {
                $role->syncPermissions();
                $role->delete();
                return redirect()->back()->with('success', 'Role removed successfully');
            }else{
                return redirect()->back()->with('info', 'Role with Users assigned can not be deleted');
            }
        }else{
            return redirect()->back()->with('error', 'Role not Found');
        }
    }
}
