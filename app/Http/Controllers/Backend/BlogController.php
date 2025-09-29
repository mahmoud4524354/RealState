<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use App\Models\BlogCategory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    use FileUploadTrait;

    public function AllBlogCategory()
    {

        $category = BlogCategory::latest()->get();
        return view('backend.category.blog_category', compact('category'));

    }


    public function StoreBlogCategory(Request $request)
    {

        BlogCategory::create([
            'category_name' => $request->category_name,
            'category_slug' => strtolower(str_replace(' ', '-', $request->category_name)),
        ]);

        toastr()->success('Blog Category Added Successfully');
        return redirect()->route('all.blog.category');

    }


    public function EditBlogCategory($id)
    {

        $categories = BlogCategory::findOrFail($id);
        return response()->json($categories);

    }

    public function UpdateBlogCategory(Request $request)
    {

        $id = $request->cat_id;

        $categories = BlogCategory::findOrFail($id);

        $categories->update([
            'category_name' => $request->category_name,
            'category_slug' => strtolower(str_replace(' ', '-', $request->category_name)),
        ]);

        toastr()->success('Blog Category Updated Successfully');
        return redirect()->route('all.blog.category');
    }

    public function DeleteBlogCategory($id)
    {

        BlogCategory::findOrFail($id)->delete();

        toastr()->success('Blog Category Deleted Successfully');
        return redirect()->route('all.blog.category');
    }


    public function AllPost()
    {

        $post = BlogPost::latest()->get();
        return view('backend.post.all_post', compact('post'));

    }


    public function AddPost()
    {

        $blogcat = BlogCategory::latest()->get();
        return view('backend.post.add_post', compact('blogcat'));

    }

    public function StorePost(Request $request)
    {

        $image = $this->uploadImage($request, 'post_image');

        BlogPost::create([
            'blogcat_id' => $request->blogcat_id,
            'user_id' => Auth::user()->id,
            'post_title' => $request->post_title,
            'post_slug' => strtolower(str_replace(' ', '-', $request->post_title)),
            'short_descp' => $request->short_descp,
            'long_descp' => $request->long_descp,
            'post_tags' => $request->post_tags,
            'post_image' => $image,
        ]);

        toastr()->success('Post Added Successfully');

        return redirect()->route('all.post');

    }


    public function EditPost($id)
    {

        $blogcat = BlogCategory::latest()->get();
        $post = BlogPost::findOrFail($id);
        return view('backend.post.edit_post', compact('post', 'blogcat'));

    }


    public function UpdatePost(Request $request)
    {
        $post_id = $request->id;
        $post = BlogPost::findOrFail($post_id);

        $image = $this->uploadImage($request, 'post_image');

        BlogPost::findOrFail($post_id)->update([
            'blogcat_id' => $request->blogcat_id,
            'user_id' => Auth::user()->id,
            'post_title' => $request->post_title,
            'post_slug' => strtolower(str_replace(' ', '-', $request->post_title)),
            'short_descp' => $request->short_descp,
            'long_descp' => $request->long_descp,
            'post_tags' => $request->post_tags,
            'post_image' => $image ?? $post->post_image,
        ]);

        toastr()->success('Post Updated Successfully');
        return redirect()->route('all.post');
    }

    public function DeletePost($id)
    {
        $post = BlogPost::findOrFail($id);

        $this->removeImage($post->post_image);
        $post->delete();

        toastr()->success('Post Deleted Successfully');
        return redirect()->back();

    }


    public function BlogDetails($slug){

        $blog = BlogPost::where('post_slug',$slug)->first();
        $tags = $blog->post_tags;
        $all_tags = explode(',',$tags);

        $categories = BlogCategory::latest()->get();
        $recent_posts = BlogPost::latest()->limit(3)->get();

        return view('frontend.blog.blog_details',get_defined_vars());

    }


    public function BlogCatList($id){

        $blog = BlogPost::where('blogcat_id',$id)->get();
        $breadcat = BlogCategory::where('id',$id)->first();
        $categories = BlogCategory::latest()->get();
        $recent_posts = BlogPost::latest()->limit(3)->get();

        return view('frontend.blog.blog_category_list', get_defined_vars());

    }


}

