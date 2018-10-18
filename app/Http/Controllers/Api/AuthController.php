<?php

namespace App\Http\Controllers\Api;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = validator()->make($request->all(),[
            'name' => 'required',
            'city_id' => 'required',
            'phone' => 'required|unique:clients',
            'donation_last_date' => 'required',
            'blood_type' => 'required|in:O-,O+,B-,B+,A+,A-,AB-,AB+',
            'password' => 'required|confirmed',
            'email' => 'required|unique:clients',
        ]);

        if ($validator->fails())
        {
            return responseJson(0,$validator->errors()->first(),$validator->errors());
        }

        $request->merge(['password' => bcrypt($request->password)]);
        $client = Client::create($request->all());
        $client->api_token = str_random(60);
        $client->save();
        return responseJson(1,'تم الاضافة بنجاح',[
            'api_token' => $client->api_token,
            'client' => $client
        ]);
    }

    public function login(Request $request)
    {
        $validator = validator()->make($request->all(),[
            'phone' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails())
        {
            return responseJson(0,$validator->errors()->first(),$validator->errors());
        }

        $client = Client::where('phone',$request->phone)->first();
        if ($client)
        {
            if (Hash::check($request->password,$client->password))
            {
                return responseJson(1,'تم تسجيل الدخول',[
                    'api_token' => $client->api_token,
                    'client' => $client
                ]);
            }else{
                return responseJson(0,'بيانات الدخول غير صحيحة');
            }
        }else{
            return responseJson(0,'بيانات الدخول غير صحيحة');
        }
    }

    public function profile(Request $request)
    {

    }

}
