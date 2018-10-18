<?php

namespace App\Http\Controllers\Api;

use App\Models\CarModel;
use App\Models\CarType;
use App\Models\City;
use App\Models\Governorate;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MainController extends Controller
{
    public function posts()
    {
        $posts = Post::with('category')->paginate(10);
        return responseJson(1,'success',$posts);
    }

    public function governorates()
    {
        $governorates = Governorate::all();
        return responseJson(1,'success',$governorates);
    }

    public function cities(Request $request)
    {
        $cities = City::where(function ($query) use($request){
            if ($request->has('governorate_id'))
            {
                $query->where('governorate_id',$request->governorate_id);
            }
        })->get();
        return responseJson(1,'success',$cities);
    }
}
