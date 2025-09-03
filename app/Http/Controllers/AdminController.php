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


    public function index(){
        return view('admin.index');
    }


    public function login(){
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

        $user->photo = $this->uploadImage(
            $request,
            'photo',
            $user->photo ?? null,
            'upload/'
        );


        $user->update([
            'username' => $request->username,
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'address'  => $request->address,
        ]);

        toastr()->success('Profile Updated Successfully');

        return back();
    }


    public function AdminChangePassword(){

        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('admin.admin_change_password',compact('profileData'));

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
}
