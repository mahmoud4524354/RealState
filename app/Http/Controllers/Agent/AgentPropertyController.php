<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\PropertyMessage;
use App\Models\State;
use App\Models\User;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\MultiImage;
use App\Models\Facility;
use App\Models\Amenities;
use App\Models\PropertyType;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AgentPropertyController extends Controller
{
    use FileUploadTrait;

    public function AgentAllProperty()
    {

        $id = Auth::user()->id;
        $property = Property::where('agent_id', $id)->latest()->get();
        return view('agent.property.all_property', compact('property'));

    } // End Method


    public function AgentAddProperty()
    {

        $propertytype = PropertyType::latest()->get();
        $amenities = Amenities::latest()->get();
        $pstate = State::latest()->get();

        $id = Auth::user()->id;
        $property = User::where('role','agent')->where('id',$id)->first();
        $pcount = $property->credit;

        if ($pcount <= 0) {
            return redirect()->route('buy.package');
        }else{

            return view('agent.property.add_property',compact('propertytype','amenities','pstate'));
        }

    }

    public function AgentStoreProperty(Request $request)
    {

        $id = Auth::user()->id;
        $user = User::findOrFail($id);
        $nid = $user->credit;

        $amen = $request->amenities_id;
        $amenites = implode(",", $amen);
        // dd($amenites);

        $pcode = IdGenerator::generate(['table' => 'properties', 'field' => 'property_code', 'length' => 5, 'prefix' => 'PC']);


        $image = $this->uploadImage($request, 'property_thambnail') ?? 'uploads/no_image.jpg';

        $property_id = Property::insertGetId([

            'ptype_id' => $request->ptype_id,
            'amenities_id' => $amenites,
            'property_name' => $request->property_name,
            'property_slug' => strtolower(str_replace(' ', '-', $request->property_name)),
            'property_code' => $pcode,
            'property_status' => $request->property_status,

            'lowest_price' => $request->lowest_price,
            'max_price' => $request->max_price,
            'short_descp' => $request->short_descp,
            'long_descp' => $request->long_descp,
            'bedrooms' => $request->bedrooms,
            'bathrooms' => $request->bathrooms,
            'garage' => $request->garage,
            'garage_size' => $request->garage_size,

            'property_size' => $request->property_size,
            'property_video' => $request->property_video,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'postal_code' => $request->postal_code,

            'neighborhood' => $request->neighborhood,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'featured' => $request->featured,
            'hot' => $request->hot,
            'agent_id' => Auth::user()->id,
            'status' => 1,
            'property_thambnail' => $image,
            'created_at' => Carbon::now(),
        ]);

        /// Multiple Image Upload From Here ////
        $images = $request->file('multi_img');
        if ($images) {
            foreach ($images as $img) {
                $ext = $img->getClientOriginalExtension();
                $imageName = 'media_' . uniqid() . '.' . $ext;
                $path = "/uploads";
                $img->move(public_path($path), $imageName);

                MultiImage::insert([
                    'property_id' => $property_id,
                    'photo_name' => $path . '/' . $imageName,
                    'created_at' => Carbon::now(),
                ]);
            }
        }

        /// End Multiple Image Upload From Here ////

        /// Facilities Add From Here ////

        $facilities = Count($request->facility_name);

        if ($facilities != NULL) {
            for ($i = 0; $i < $facilities; $i++) {
                $fcount = new Facility();
                $fcount->property_id = $property_id;
                $fcount->facility_name = $request->facility_name[$i];
                $fcount->distance = $request->distance[$i];
                $fcount->save();
            }
        }

        /// End Facilities  ////

        $user->decrement('credit', 1);

        toastr()->success('Property added successfully!');
        return redirect()->route('agent.all.property');

    }// End Method


    public function AgentEditProperty($id)
    {

        $facilities = Facility::where('property_id', $id)->get();
        $property = Property::findOrFail($id);

        $type = $property->amenities_id;
        $property_ami = explode(',', $type);

        $multiImage = MultiImage::where('property_id', $id)->get();

        $propertytype = PropertyType::latest()->get();
        $amenities = Amenities::latest()->get();
        $pstate = State::latest()->get();

        return view('agent.property.edit_property',get_defined_vars());

    }// End Method

    public function AgentUpdateProperty(Request $request)
    {

        $amen = $request->amenities_id;
        $amenites = implode(",", $amen);

        $property_id = $request->id;

        Property::findOrFail($property_id)->update([

            'ptype_id' => $request->ptype_id,
            'amenities_id' => $amenites,
            'property_name' => $request->property_name,
            'property_slug' => strtolower(str_replace(' ', '-', $request->property_name)),
            'property_status' => $request->property_status,

            'lowest_price' => $request->lowest_price,
            'max_price' => $request->max_price,
            'short_descp' => $request->short_descp,
            'long_descp' => $request->long_descp,
            'bedrooms' => $request->bedrooms,
            'bathrooms' => $request->bathrooms,
            'garage' => $request->garage,
            'garage_size' => $request->garage_size,

            'property_size' => $request->property_size,
            'property_video' => $request->property_video,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'postal_code' => $request->postal_code,

            'neighborhood' => $request->neighborhood,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'featured' => $request->featured,
            'hot' => $request->hot,
            'agent_id' => Auth::user()->id,
            'updated_at' => Carbon::now(),

        ]);

        toastr()->success('Property Updated Successfully');

        return redirect()->route('agent.all.property');

    }// End Method


    public function AgentUpdatePropertyThambnail(Request $request)
    {

        $pro_id = $request->id;
        $oldImage = $request->old_img;


        if ($request->hasFile('property_thambnail')) {
            $save_url = $this->uploadImage($request, 'property_thambnail');
        } else {
            $save_url = $oldImage;
        }


        Property::findOrFail($pro_id)->update([

            'property_thambnail' => $save_url,
            'updated_at' => Carbon::now(),
        ]);

        toastr()->success('Property Updated Successfully');

        return redirect()->back();

    }// End Method


    public function AgentUpdatePropertyMultiimage(Request $request)
    {
        $imgs = $request->multi_img;

        foreach ((array)$imgs as $id => $img) {
            $imgDel = MultiImage::findOrFail($id);

            $uploadPath = $this->uploadImage(
                $request,
                "multi_img.$id",
                $imgDel->photo_name,
                'uploads'
            );

            if ($uploadPath) {
                $imgDel->update([
                    'photo_name' => $uploadPath,
                    'updated_at' => now(),
                ]);
            }
        }

        toastr()->success('Property Multi Image Updated Successfully');
        return redirect()->back();
    }

//============================================

    public function AgentPropertyMultiimgDelete($id)
    {
        $image = MultiImage::findOrFail($id);

        $this->removeImage($image->photo_name);

        $image->delete();

        toastr()->success('Property Multi Image Deleted Successfully');

        return back();
    }


    public function AgentStoreNewMultiimage(Request $request)
    {

        $new_multi = $request->imageid;

        $uploadPath = $this->uploadImage($request, 'multi_img', 'uploads');

        MultiImage::insert([
            'property_id' => $new_multi,
            'photo_name' => $uploadPath,
            'created_at' => \Illuminate\Support\Carbon::now(),
        ]);

        toastr()->success('Multi Image Added Successfully');

        return redirect()->back();
    }// End Method


    public function AgentUpdatePropertyFacilities(Request $request)
    {

        $pid = $request->id;

        if ($request->facility_name == NULL) {
            return redirect()->back();
        } else {
            Facility::where('property_id', $pid)->delete();

            $facilities = Count($request->facility_name);

            for ($i = 0; $i < $facilities; $i++) {
                $fcount = new Facility();
                $fcount->property_id = $pid;
                $fcount->facility_name = $request->facility_name[$i];
                $fcount->distance = $request->distance[$i];
                $fcount->save();
            }
        }

        toastr()->success('Property Facilities Updated Successfully');

        return redirect()->back();

    }// End Method


    public function AgentDetailsProperty($id)
    {

        $facilities = Facility::where('property_id', $id)->get();
        $property = Property::findOrFail($id);

        $type = $property->amenities_id;
        $property_ami = explode(',', $type);

        $multiImage = MultiImage::where('property_id', $id)->get();

        $propertytype = PropertyType::latest()->get();
        $amenities = Amenities::latest()->get();


        return view('agent.property.details_property', compact('property', 'propertytype', 'amenities', 'property_ami', 'multiImage', 'facilities'));

    }// End Method


    public function AgentDeleteProperty($id)
    {

        $property = Property::findOrFail($id);
        $this->removeImage($property->property_thambnail);

        Property::findOrFail($id)->delete();

        $image = MultiImage::where('property_id', $id)->get();

        foreach ($image as $img) {
            $this->removeImage($img->photo_name);
        }

        $facilitiesData = Facility::where('property_id', $id)->get();
        foreach ($facilitiesData as $item) {
            $item->facility_name;
            Facility::where('property_id', $id)->delete();
        }

        toastr()->success('Property Deleted Successfully');

        return redirect()->back();

    }// End Method



    public function AgentPropertyMessage(){

        $id = Auth::user()->id;
        $usermsg = PropertyMessage::where('agent_id',$id)->get();
        return view('agent.message.all_message',compact('usermsg'));

    }

    public function AgentMessageDetails($id){

        $uid = Auth::user()->id;
        $usermsg = PropertyMessage::where('agent_id',$uid)->get();

        $msgdetails = PropertyMessage::findOrFail($id);
        return view('agent.message.message_details',compact('usermsg','msgdetails'));

    }



}
