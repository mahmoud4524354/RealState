<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Add_typeRequest;
use App\Models\PropertyType;
use Illuminate\Http\Request;

class PropertyTypeController extends Controller
{
    public function allTypes(){
        $types = PropertyType::get();
        return view('backend.type.all_type',compact('types'));
    }

    public function addType(){
        return view('backend.type.add_type');
    }

    public function storeType(Add_typeRequest $request){
        $data = $request->validated();

        PropertyType::create($data);
        toastr()->success('Data Added Successfully');
        return redirect()->route('all.type');
    }

    public function editType($id){
//        $types = PropertyType::findOrFail($id);

        $types = PropertyType::where('id', $id)->first();
        return view('backend.type.edit_type',compact('types'));
    }

    public function updateType(Request $request, $id)
    {
        $request->validate([
            'type_name' => 'required|max:200|unique:property_types,type_name,'.$id,
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

    public function deleteType($id){
        PropertyType::findOrFail($id)->delete();

        toastr()->success('Data Deleted Successfully',);
        return redirect()->route('all.type');
    }
}
