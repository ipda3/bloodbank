<?php

namespace App\Http\Controllers\Front;

use App\Models\Client;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MainController extends Controller
{
    public function home(Request $request)
    {
        $posts = Post::published()->take(9)->get();
        return view('front.home',compact('posts'));
    }


    public function about()
    {
        return view('front.about');
    }

    public function toggleFavourite(Request $request)
    {
        $toggle = $request->user()->favourites()->toggle($request->post_id);
        return responseJson(1,'success',$toggle);
    }
}
