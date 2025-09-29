<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogCategory;
use Carbon\Carbon;

class BlogController extends Controller
{
    public function AllBlogCategory(){

        $category = BlogCategory::latest()->get();
        return view('backend.category.blog_category',compact('category'));

    }


    public function StoreBlogCategory(Request $request){

        BlogCategory::create([
            'category_name' => $request->category_name,
            'category_slug' => strtolower(str_replace(' ','-',$request->category_name)),
        ]);

        toastr()->success('Blog Category Added Successfully');
        return redirect()->route('all.blog.category');

    }


    public function EditBlogCategory($id){

        $categories = BlogCategory::findOrFail($id);
        return response()->json($categories);

    }

    public function UpdateBlogCategory(Request $request){

        $id = $request->cat_id ;

        $categories = BlogCategory::findOrFail($id);

        $categories->update([
            'category_name' => $request->category_name,
            'category_slug' => strtolower(str_replace(' ','-',$request->category_name)),
        ]);

        toastr()->success('Blog Category Updated Successfully');
        return redirect()->route('all.blog.category');
    }

    public function DeleteBlogCategory($id){

        BlogCategory::findOrFail($id)->delete();

        toastr()->success('Blog Category Deleted Successfully');
        return redirect()->route('all.blog.category');
    }


}

