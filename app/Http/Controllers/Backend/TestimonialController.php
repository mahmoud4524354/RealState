<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use App\Models\Testimonial;

class TestimonialController extends Controller
{
    use FileUploadTrait;

    public function AllTestimonials()
    {

        $testimonial = Testimonial::latest()->get();
        return view('backend.testimonial.all_testimonial', compact('testimonial'));

    }


    public function AddTestimonials()
    {
        return view('backend.testimonial.add_testimonial');
    }

    public function StoreTestimonials(Request $request)
    {

        $image = $this->uploadImage($request, 'image');

        Testimonial::insert([
            'name' => $request->name,
            'position' => $request->position,
            'message' => $request->message,
            'image' => $image,
        ]);

        toastr()->success('Testimonial Added Successfully');

        return redirect()->route('all.testimonials');

    }


    public function EditTestimonials($id)
    {

        $testimonial = Testimonial::findOrFail($id);
        return view('backend.testimonial.edit_testimonial', compact('testimonial'));

    }


    public function UpdateTestimonials(Request $request)
    {

        $id = $request->id;

        if ($request->file('image')) {

            $image = $this->uploadImage($request, 'image');

            Testimonial::findOrFail($id)->update([
                'name' => $request->name,
                'position' => $request->position,
                'message' => $request->message,
                'image' => $image,
            ]);

            toastr()->success('Testimonial Updated Successfully');

            return redirect()->route('all.testimonials');

        } else {

            Testimonial::findOrFail($id)->update([
                'name' => $request->name,
                'position' => $request->position,
                'message' => $request->message,
            ]);

            toastr()->success('Testimonial Updated Successfully');

            return redirect()->route('all.testimonials');

        }

    }

    public function DeleteTestimonials($id)
    {

        $testimonial = Testimonial::findOrFail($id);

        if ($testimonial->image) {
            $this->removeImage($testimonial->image);
        }

        $testimonial->delete();

        toastr()->success('Testimonial Deleted Successfully');

        return redirect()->back();

    }


}

