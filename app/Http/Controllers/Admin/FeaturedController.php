<?php

namespace App\Http\Controllers\Admin;

use App\Featured;
use App\Post;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FeaturedController extends Controller
{
    public function index()
    {
        $featureds = Featured::latest()->get();
        return view('admin.featured.index',compact('featureds'));
    }

    public function create()
    {
        $posts = Post::all();
        return view('admin.featured.create',compact('posts'));
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'posts' => 'required'
        ]);
        $featureds = new Featured();
        $featureds->posts()->attach($request->posts);
        $featureds->save();
        Toastr::success('Featured Successfully Saved :)' ,'Success');
        return redirect()->route('admin.featured.index');
    }

    public function edit($id)
    {
        $featureds = Featured::find($id);
        $posts = Post::all();
        return view('admin.featured.edit',compact('featureds', 'posts'));
    }

    public function update(Request $request, $id)
    {
        $featureds = Tag::find($id);
        $featureds->post_id = $request->id;
        $featureds->save();
        Toastr::success('Featured Successfully Updated :)','Success');
        return redirect()->route('admin.tag.index');
    }

    public function destroy($id)
    {
        Featured::find($id)->delete();
        Toastr::success('Featured Successfully Deleted :)','Success');
        return redirect()->back();
    }
}
