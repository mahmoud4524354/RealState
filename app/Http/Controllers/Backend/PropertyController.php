<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Amenities;
use App\Models\Facility;
use App\Models\MultiImage;
use App\Models\PackagePlan;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\User;
use App\Traits\FileUploadTrait;
use Barryvdh\DomPDF\Facade\Pdf;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use League\CommonMark\Extension\CommonMark\Node\Inline\Image;

class PropertyController extends Controller
{
    use FileUploadTrait;

    public function allProperty()
    {
        $property = Property::latest()->get();
        return view('backend.property.all_property', compact('property'));
    }

    public function addProperty()
    {
        $propertytype = PropertyType::latest()->get();
        $amenities = Amenities::latest()->get();
        $activeAgent = User::where('status', 'active')->where('role', 'agent')->latest()->get();

        return view('backend.property.add_property', get_defined_vars());
    }


    public function storeProperty(Request $request)
    {
        $thumbnailPath = $this->uploadImage($request, 'property_thambnail');

        $amen = (array)$request->amenities_id;
        $amenites = implode(",", $amen);

        $pcode = IdGenerator::generate(['table' => 'properties', 'field' => 'property_code', 'length' => 5, 'prefix' => 'PC']);

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
            'agent_id' => $request->agent_id,
            'status' => 1,
            'property_thambnail' => $thumbnailPath,
            'created_at' => Carbon::now(),
        ]);


        MultiImage::insert([

            'property_id' => $property_id,
            'photo_name' => $thumbnailPath,
            'created_at' => Carbon::now(),

        ]);


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


        toastr()->success('Property Added Successfully');
        return redirect()->route('all.property');
    }

    public function editProperty($id)
    {

        $propertytype = PropertyType::latest()->get();
        $amenities = Amenities::latest()->get();
        $activeAgent = User::where('role', 'agent')->where('status', 'active')->latest()->get();

        $facilities = Facility::where('property_id', $id)->get();
        $property = Property::findOrFail($id);

        $type = $property->amenities_id;
        $property_ami = explode(',', $type);

        $multiImage = MultiImage::where('property_id', $id)->get();

        return view('backend.property.edit_property', get_defined_vars());

    }

    public function updateProperty(Request $request)
    {

        $amen = $request->amenities_id;
        $amenites = implode(",", $amen);

        $property = Property::findOrFail($request->id);

        $property->update([

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
            'agent_id' => $request->agent_id,
            'updated_at' => Carbon::now(),
        ]);

//

        toastr()->success('Property Updated Successfully');
        return redirect()->route('all.property');
    }

    public function UpdatePropertyThambnail(Request $request)
    {
        $property = Property::findOrFail($request->id);

        $imagePath = $this->uploadImage($request, 'property_thambnail');
        $property->property_thambnail = $imagePath;

        $property->save();

        toastr()->success('Property Updated Successfully');
        return redirect()->route('all.property');
    }


    public function UpdatePropertyMultiimage(Request $request)
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


    public function PropertyMultiImageDelete($id)
    {
        $multiImage = MultiImage::findOrFail($id);

        $this->removeImage($multiImage->photo_name);

        $multiImage->delete();

        toastr()->success('Property Multi Image Deleted Successfully');
        return redirect()->back();
    }

    public function StoreNewMultiimage(Request $request)
    {

        $new_multi = $request->imageid;

        $uploadPath = $this->uploadImage($request, 'multi_img', 'uploads');

        MultiImage::insert([
            'property_id' => $new_multi,
            'photo_name' => $uploadPath,
            'created_at' => Carbon::now(),
        ]);

        toastr()->success('Multi Image Added Successfully');

        return redirect()->back();
    }

    public function UpdatePropertyFacilities(Request $request)
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

        toastr()->success('Property Updated Successfully');
        return redirect()->back();
    }

    public function DeleteProperty($id)
    {

        $property = Property::findOrFail($id);
        Property::findOrFail($id)->delete();

        $this->removeImage($property->property_thambnail);

        $image = MultiImage::where('property_id', $id)->get();

        foreach ($image as $img) {
            $this->removeImage($img->photo_name);
        }
        MultiImage::where('property_id', $id)->delete();

        $facilitiesData = Facility::where('property_id', $id)->get();
        foreach ($facilitiesData as $item) {
            $item->facility_name;
            Facility::where('property_id', $id)->delete();
        }

        toastr()->success('Property Deleted Successfully');

        return redirect()->back();
    }

    public function DetailsProperty($id)
    {

        $facilities = Facility::where('property_id', $id)->get();
        $property = Property::findOrFail($id);

        $type = $property->amenities_id;
        $property_ami = explode(',', $type);

        $multiImage = MultiImage::where('property_id', $id)->get();

        $propertytype = PropertyType::latest()->get();
        $amenities = Amenities::latest()->get();
        $activeAgent = User::where('status', 'active')->where('role', 'agent')->latest()->get();

        return view('backend.property.details_property', compact('property', 'propertytype', 'amenities', 'activeAgent', 'property_ami', 'multiImage', 'facilities'));
    }

    public function InactiveProperty(Request $request)
    {

        $pid = $request->id;
        Property::findOrFail($pid)->update([

            'status' => 0,

        ]);
        toastr()->success('Property Updated Successfully');

        return redirect()->route('all.property');
    }

    public function ActiveProperty(Request $request)
    {

        $pid = $request->id;
        Property::findOrFail($pid)->update([

            'status' => 1,

        ]);

        toastr()->success('Property Updated Successfully');

        return redirect()->route('all.property');;
    }


    public function AdminPackageHistory()
    {

        $packagehistory = PackagePlan::latest()->get();
        return view('backend.package.package_history', compact('packagehistory'));
    }

    public function PackageInvoice($id)
    {

        $packagehistory = PackagePlan::where('id', $id)->first();

        $pdf = Pdf::loadView('backend.package.package_history_invoice', compact('packagehistory'))->setPaper('a4')->setOption([
            'tempDir' => public_path(),
            'chroot' => public_path(),
        ]);
        return $pdf->download('invoice.pdf');

    }
}
