<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Review;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Post::latest()->paginate(6);
        return view('posts',compact('reviews'));
    }
    public function details($slug)
    {
        $review = Reviews::where('slug',$slug)->first();

        $latestreviews = Review::latest()->take(5)->get();
        return view('review',compact('review','latestreviews'));

    }
}
