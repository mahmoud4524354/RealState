<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PropertyType;
use App\Models\State;
use Intervention\Image\Facades\Image;

class StateController extends Controller
{
    use FileUploadTrait;

    public function AllState()
    {
        $state = State::latest()->get();
        return view('backend.state.all_state', compact('state'));
    }

    public function AddState()
    {
        return view('backend.state.add_state');
    }


    public function StoreState(Request $request)
    {

        $image = $this->uploadImage($request, 'state_image');
        State::insert([
            'state_name' => $request->state_name,
            'state_image' => $image,
        ]);

        toastr()->success('State Added Successfully');

        return redirect()->route('all.state');

    }


    public function EditState($id)
    {

        $state = State::findOrFail($id);
        return view('backend.state.edit_state', compact('state'));

    }


    public function UpdateState(Request $request)
    {

        $state_id = $request->id;

        if ($request->file('state_image')) {

            $image = $this->uploadImage($request, 'state_image');

            State::findOrFail($state_id)->update([
                'state_name' => $request->state_name,
                'state_image' => $image,
            ]);

            toastr()->success('State Updated Successfully');

            return redirect()->route('all.state');

        } else {

            State::findOrFail($state_id)->update([
                'state_name' => $request->state_name,
            ]);

            toastr()->success('State Updated without Image Successfully');

            return redirect()->route('all.state');
        }

    }


    public function DeleteState($id)
    {
        $state = State::findOrFail($id);

        if ($state->state_image) {
            $this->removeImage($state->state_image);
        }

        $state->delete();

        toastr()->success('State Deleted Successfully');
        return redirect()->back();
    }

}
