<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        $featureds = Post::latest()->approved()->published()->featured()->take(4)->get();
        $posts = Post::latest()->approved()->published()->take(6)->get();
        return view('welcome',compact('categories','posts','featureds'));
    }
}
