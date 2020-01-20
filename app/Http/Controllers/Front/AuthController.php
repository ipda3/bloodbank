<?php

namespace App\Http\Controllers\Front;

use App\Models\Governorate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function register()
    {
        return view('front.register');
    }

    public function registerSave(Request $request)
    {

    }
}
