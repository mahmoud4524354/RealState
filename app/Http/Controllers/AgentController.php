<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Exists;

class AgentController extends Controller
{
    use FileUploadTrait;

    public function index()
    {
        return view('agent.index');
    }

    public function login()
    {
        return view('agent.agent_login');
    }

    public function AgentProfile()
    {
        $id = Auth::user()->id;
        $profileData = User::find($id);

        return view('agent.agent_profile', compact('profileData'));
    }

    public function agentProfileUpdate(Request $request)
    {
        $id = Auth::user()->id;
        $user = User::find($id);

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

    public function AgentChangePassword()
    {

        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('agent.agent_change_password', compact('profileData'));

    }

    public function AgentUpdatePassword(Request $request)
    {

        // Validation
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed'

        ]);

        /// Match The Old Password
        if (!Hash::check($request->old_password, auth::user()->password)) {

            toastr()->error('Old Password Does not Match!');
            return back();
        }

        /// Update The New Password
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)

        ]);

        toastr()->success('Password Updated Successfully');
        return back();

    }

}
