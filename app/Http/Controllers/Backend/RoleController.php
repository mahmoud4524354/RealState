<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

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


}
