<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use FileUploadTrait;

    public function index()
    {
        return view('frontend.index');
    }

    public function UserProfile()
    {

        $id = Auth::user()->id;
        $userData = User::find($id);
        return view('frontend.dashboard.edit_profile', compact('userData'));

    }

    public function UserProfileStore(Request $request)
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

    public function UserChangePassword()
    {

        return view('frontend.dashboard.change_password');

    }

    public function UserUpdatePassword(Request $request)
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
        return redirect()->route('login');
    }

}
