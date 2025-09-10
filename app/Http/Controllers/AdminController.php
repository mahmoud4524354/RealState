<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Traits\FileUploadTrait;
use \Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    use FileUploadTrait;


    public function index()
    {
        return view('admin.index');
    }


    public function login()
    {
        return view('admin.admin_login');
    }

    public function AdminProfile()
    {
        $profileData = Auth::user();
        return view('admin.admin_profile_view', compact('profileData'));
    }

    public function AdminProfileUpdate(Request $request)
    {
        $user = Auth::user();

        if ($request->hasFile('photo')) {
            $user->photo = $this->uploadImage($request, 'photo');
        }

        $user->update([
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        toastr()->success('Profile Updated Successfully');

        return back();
    }


    public function AdminChangePassword()
    {

        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('admin.admin_change_password', compact('profileData'));

    }

    public function AdminUpdatePassword(Request $request)
    {
        // Validation
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed|min:8',
        ]);

        // Match The Old Password
        if (!Hash::check($request->old_password, Auth::user()->password)) {
            toastr()->error('Old password does not match');
            return back();
        }

        // Update The New Password
        $user = Auth::user();
        $user->password = Hash::make($request->new_password);
        $user->save();

        Auth::logout();
        toastr()->success('Password Changed Successfully. Please login again.');
        return redirect()->route('admin/login');
    }


    public function allAgent()
    {

        $allagent = User::where('role', 'agent')->get();
        return view('backend.agentuser.all_agent', compact('allagent'));

    }

    public function addAgent()
    {

        return view('backend.agentuser.add_agent');

    }

    public function storeAgent(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'password' => 'required|string|min:6',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);


        $photo = $request->hasFile('photo') ? $this->uploadImage($request, 'photo') : null;

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password),
            'role' => 'agent',
            'status' => 'active',
            'photo' => $photo,
        ]);

        toastr()->success('Agent Created Successfully');
        return redirect()->route('all.agent');
    }

    public function editAgent($id)
    {

        $allagent = User::findOrFail($id);
        return view('backend.agentuser.edit_agent', compact('allagent'));

    }

    public function updateAgent(Request $request, $id)
    {
        $agent = User::where('role', 'agent')->findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $agent->id,
            'phone'    => 'nullable|string|max:20',
            'address'  => 'nullable|string|max:255',
            'password' => 'nullable|string|min:6',
            'photo'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->filled('password')) {
            $password = hash::make($request->password);
        }else{
            $password = $agent->password;
        }


        if($request->hasFile('photo')){
            $photo =$this->uploadImage($request, 'photo');
        }else{
            $photo = $agent->photo;
        }


        $agent->update([
            'name'    => $request->name,
            'email'   => $request->email,
            'phone'   => $request->phone,
            'address' => $request->address,
            'password' => $password,
            'photo'   => $photo,
        ]);


        toastr()->success('Agent Updated Successfully');
        return redirect()->route('all.agent');

    }

    public function DeleteAgent($id)
    {

        User::findOrFail($id)->delete();

        toastr()->success('Agent Deleted Successfully');
        return redirect()->back();
    }

    public function changeStatus(Request $request)
    {

        $user = User::find($request->user_id);
        $user->status = $request->status;
        $user->save();

        return response()->json(['success' => 'Status Change Successfully']);

    }

}

