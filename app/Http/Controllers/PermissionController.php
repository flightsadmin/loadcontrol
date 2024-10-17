<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view permission', ['only' => ['index']]);
        $this->middleware('permission:create permission', ['only' => ['create', 'store']]);
        $this->middleware('permission:update permission', ['only' => ['update', 'edit']]);
        $this->middleware('permission:delete permission', ['only' => ['destroy']]);
    }

    public function index()
    {
        $permissions = Permission::get();

        return view('role-permission.permission.index', ['permissions' => $permissions]);
    }

    public function create()
    {
        return view('role-permission.permission.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'unique:permissions,name',
            ],
        ]);

        Permission::create([
            'name' => $request->name,
        ]);

        return redirect('permissions')->with('status', 'Permission Created Successfully');
    }

    public function edit(Permission $permission)
    {
        return view('role-permission.permission.edit', ['permission' => $permission]);
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'unique:permissions,name,'.$permission->id,
            ],
        ]);

        $permission->update([
            'name' => $request->name,
        ]);

        return redirect('permissions')->with('status', 'Permission Updated Successfully');
    }

    public function show(Permission $permission)
    {
        $permissions = Permission::with('roles')->get();

        return view('role-permission.permission.index', compact('permissions'));
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();

        return redirect('permissions')->with('status', 'Permission Deleted Successfully');
    }
}
