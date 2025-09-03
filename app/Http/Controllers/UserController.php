<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $user->photo = $this->uploadImage(
            $request,
            'photo',
            $user->photo ?? null,
            'upload/'
        );


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

}
