<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Add_typeRequest;
use App\Models\Amenities;
use App\Models\PropertyType;
use Illuminate\Http\Request;

class PropertyTypeController extends Controller
{
    public function allTypes()
    {
        $types = PropertyType::get();
        return view('backend.type.all_type', compact('types'));
    }

    public function addType()
    {
        return view('backend.type.add_type');
    }

    public function storeType(Add_typeRequest $request)
    {
        $data = $request->validated();

        PropertyType::create($data);
        toastr()->success('Data Added Successfully');
        return redirect()->route('all.type');
    }

    public function editType($id)
    {
//        $types = PropertyType::findOrFail($id);

        $types = PropertyType::where('id', $id)->first();
        return view('backend.type.edit_type', compact('types'));
    }

    public function updateType(Request $request, $id)
    {
        $request->validate([
            'type_name' => 'required|max:200|unique:property_types,type_name,' . $id,
            'type_icon' => 'required'
        ]);

        $data = PropertyType::findOrFail($id);

        $data->update([
            'type_name' => $request->type_name,
            'type_icon' => $request->type_icon,
        ]);

        toastr()->success('Data Updated Successfully');
        return redirect()->route('all.type');
    }

    public function deleteType($id)
    {
        PropertyType::findOrFail($id)->delete();

        toastr()->success('Data Deleted Successfully');
        return redirect()->route('all.type');
    }


    ///////////// Amenitites All Method //////////////

    public function allAmenitie()
    {

        $amenities = Amenities::latest()->get();
        return view('backend.amenities.all_amenities', compact('amenities'));

    }

    public function addAmenitie()
    {
        return view('backend.amenities.add_amenities');
    }

    public function storeAmenitie(Request $request)
    {
        $request->validate([
            'amenitis_name' => ['required', 'string'],
        ]);

        Amenities::create([
            'amenitis_name' => $request->amenitis_name,
        ]);

        toastr()->success('Data Created Successfully');
        return redirect()->route('all.amenitie');

    }


    public function editAmenitie($id)
    {
        $amenities = Amenities::findOrFail($id);
        return view('backend.amenities.edit_amenities', compact('amenities'));
    }


    public function updateAmenitie(Request $request, $id)
    {
        $request->validate([
            'amenitis_name' => ['required', 'string'],
        ]);

        $amenitie = Amenities::findOrFail($id);
        $amenitie->Update([
            'amenitis_name' => $request->amenitis_name,
        ]);

        toastr()->success('Data Updated Successfully');
        return redirect()->route('all.amenitie');

    }

    public function deleteAmenitie($id)
    {
        Amenities::findOrFail($id)->delete();

        toastr()->success('Data Deleted Successfully');
        return redirect()->back();

    }

}
