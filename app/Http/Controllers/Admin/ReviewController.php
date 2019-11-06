<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Notifications\AuthorPostApproved;
use App\Notifications\NewPostNotify;
use App\Subscriber;
use App\Tag;
use App\Review;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reviews = Review::latest()->get();
        return view('admin.review.index',compact('reviews'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.review.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'title' => 'required',
            'image' => 'image',
            'categories' => 'required',
            'score' => 'required',
            'developer' => 'required',
            'platform' => 'required',
            'genre' => 'required',
            'release_date' => 'required',
            'body' => 'required',
        ]);
        $image = $request->file('image');
        $slug = str_slug($request->title);
        if(isset($image))
        {
//            make unipue name for image
            $currentDate = Carbon::now()->toDateString();
            $imageName  = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();

            if(!Storage::disk('public')->exists('post'))
            {
                Storage::disk('public')->makeDirectory('post');
            }

            $postImage = Image::make($image)->resize(400,521)->stream();
            Storage::disk('public')->put('review/'.$imageName,$postImage);

        } else {
            $imageName = "default.png";
        }
        $post = new Post();
        $review->user_id = Auth::id();
        $review->title = $request->title;
        $review->slug = $slug;
        $review->image = $imageName;
        $review->score = $request->score;
        $review->platform = $request->platform;
        $review->genre = $request->genre;
        $review->release_date = $request->release_date;
        $review->developer = $request->developer;
        $review->body = $request->body;

        if(isset($request->featured))
        {
            $review->featured = true;
        }else {
            $review->featured = false;
        }

        $review->save();

        $review->categories()->attach($request->categories);

        Toastr::success('Review Successfully Saved :)','Success');
        return redirect()->route('admin.review.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('admin.post.show',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $review)
    {
        $categories = Category::all();
        return view('admin.review.edit',compact('review','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Review $review)
    {
        $this->validate($request,[
            'title' => 'required',
            'image' => 'image',
            'categories' => 'required',
            'score' => 'required',
            'developer' => 'required',
            'platform' => 'required',
            'genre' => 'required',
            'release_date' => 'required',
            'body' => 'required',
        ]);
        $image = $request->file('image');
        $slug = str_slug($request->title);
        if(isset($image))
        {
//            make unipue name for image
            $currentDate = Carbon::now()->toDateString();
            $imageName  = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();

            if(!Storage::disk('public')->exists('review'))
            {
                Storage::disk('public')->makeDirectory('review');
            }
//            delete old post image
            if(Storage::disk('public')->exists('review/'.$review->image))
            {
                Storage::disk('public')->delete('review/'.$review->image);
            }
            $postImage = Image::make($image)->resize(400,521)->stream();
            Storage::disk('public')->put('review/'.$imageName,$postImage);

        } else {
            $imageName = $review->image;
        }

        $review->user_id = Auth::id();
        $review->title = $request->title;
        $review->slug = $slug;
        $review->image = $imageName;
        $review->score = $request->score;
        $review->platform = $request->platform;
        $review->genre = $request->genre;
        $review->release_date = $request->release_date;
        $review->developer = $request->developer;
        $review->body = $request->body;

        if(isset($request->featured))
        {
            $review->featured = true;
        }else {
            $review->featured = false;
        }

        $review->save();

        $review->categories()->sync($request->categories);

        Toastr::success('Review Successfully Updated :)','Success');
        return redirect()->route('admin.review.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if (Storage::disk('public')->exists('review/'.$review->image))
        {
            Storage::disk('public')->delete('review/'.$review->image);
        }
        $review->categories()->detach();
        $review->delete();
        Toastr::success('Review Successfully Deleted :)','Success');
        return redirect()->back();
    }
}
