<?php

namespace App\Http\Controllers\Backend;

use App\Exports\PermissionExport;
use App\Http\Controllers\Controller;
use App\Imports\PermissionImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class RoleController extends Controller
{
    public function AllPermission()
    {
        $permissions = Permission::all();
        return view('backend.pages.permission.all_permission', compact('permissions'));

    }

    public function AddPermission()
    {
        return view('backend.pages.permission.add_permission');
    }

    public function StorePermission(Request $request)
    {

        Permission::create([
            'name' => $request->name,
            'group_name' => $request->group_name,
        ]);

        toastr()->success('Permission Added Successfully');
        return redirect()->route('all.permission');
    }

    public function EditPermission($id)
    {
        $permission = Permission::findOrFail($id);
        return view('backend.pages.permission.edit_permission', compact('permission'));
    }

    public function UpdatePermission(Request $request, $permission_id)
    {

        Permission::findOrFail($permission_id)->update([
            'name' => $request->name,
            'group_name' => $request->group_name,
        ]);

        toastr()->success('Permission Updated Successfully');
        return redirect()->route('all.permission');
    }

    public function DeletePermission($id)
    {
        Permission::findOrFail($id)->delete();
        toastr()->success('Permission Deleted Successfully');
        return redirect()->route('all.permission');
    }


    public function ImportPermission()
    {
        return view('backend.pages.permission.import_permission');
    }

    public function Export()
    {

        return Excel::download(new PermissionExport, 'permission.xlsx');

    }

    public function Import(Request $request)
    {
        Excel::import(new PermissionImport, $request->file('import_file'));

        toastr()->success('Permission Imported Successfully');
        return redirect()->route('all.permission');
    }


    public function AllRoles()
    {

        $roles = Role::all();
        return view('backend.pages.roles.all_roles', compact('roles'));

    }

    public function AddRoles()
    {
        return view('backend.pages.roles.add_roles');
    }

    public function StoreRoles(Request $request)
    {
        Role::Create([
            'name' => $request->name,
        ]);
        toastr()->success('Role Added Successfully');
        return redirect()->route('all.roles');
    }

    public function EditRoles($id)
    {
        $roles = Role::findOrFail($id);
        return view('backend.pages.roles.edit_roles', compact('roles'));
    }

    public function UpdateRoles(Request $request, $id)
    {
        Role::findOrFail($id)->update([
            'name' => $request->name,
        ]);
        toastr()->success('Role Updated Successfully');
        return redirect()->route('all.roles');
    }

    public function DeleteRoles($id)
    {
        Role::findOrFail($id)->delete();
        toastr()->success('Role Deleted Successfully');
        return redirect()->route('all.roles');
    }

}
