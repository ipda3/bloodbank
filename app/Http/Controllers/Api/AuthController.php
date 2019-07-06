<?php

namespace App\Http\Controllers\Api;

use App\Mail\ResetPassword;
use App\Models\BloodType;
use App\Models\Client;
use App\Models\RequestLog;
use App\Models\Token;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        RequestLog::create(['content' => $request->all(),'service' => 'register']);
        $validator = validator()->make($request->all(),[
            'name' => 'required',
            'city_id' => 'required|exists:cities,id',
            'phone' => 'required|unique:clients|digits:11',
            'donation_last_date' => 'required|date_format:Y-m-d',
            'birth_date' => 'required|date_format:Y-m-d',
            'blood_type_id' => 'required|exists:blood_types,id',
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
        $client->governorates()->attach($request->governorate_id);
        $client->bloodtypes()->attach($request->blood_type_id);
        return responseJson(1,'تم الاضافة بنجاح',[
            'api_token' => $client->api_token,
            'client' => $client->load('city.governorate','bloodType')
        ]);
    }

    public function login(Request $request)
    {
       RequestLog::create(['content' => $request->all(),'service' => 'login']);
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
                    'client' => $client->load('city.governorate','bloodType')
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
        $validation = validator()->make($request->all(), [
            'password' => 'confirmed',
            'email' => Rule::unique('clients')->ignore($request->user()->id),
            'phone' => Rule::unique('clients')->ignore($request->user()->id),
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0,$validation->errors()->first(),$data);
        }
        // Eloquent
        // auth()->user(); // user -> web
        // auth()->guard('api')->user() // user -> api
        // $request->user() // user -> middleware guard

        $loginUser = $request->user(); // object Client Model
        // eq = Client::where('api_token',$request->api_token)->first();
        // Laravel Documentation - Authentication
        $loginUser->update($request->all());


        if ($request->has('password'))
        {
            $loginUser->password = bcrypt($request->password);
        }

        $loginUser->save();

        $data = [
            'client' => $request->user()->fresh()->load('city.governorate','bloodType')
        ];
        return responseJson(1,'تم تحديث البيانات',$data);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function reset(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'phone' => 'required'
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0,$validation->errors()->first(),$data);
        }

        $user = Client::where('phone',$request->phone)->first();
        if ($user){
            $code = rand(1111,9999);
            $update = $user->update(['pin_code' => $code]);
            if ($update)
            {
                // send sms
                //smsMisr($request->phone,"your reset code is : ".$code);

                // send email
                Mail::to($user->email)
//                    ->bcc("eng.magwad@gmail.com")
                    ->send(new ResetPassword($user));

                return responseJson(1,'برجاء فحص هاتفك',
                    [
                        'pin_code_for_test' => $code,
                        'mail_fails' => Mail::failures(),
                        'email' => $user->email,
                    ]);
            }else{
                return responseJson(0,'حدث خطأ ، حاول مرة أخرى');
            }
        }else{
            return responseJson(0,'لا يوجد أي حساب مرتبط بهذا الهاتف');
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function password(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'pin_code' => 'required',
            'phone' => 'required',
            'password' => 'required|confirmed'
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0,$validation->errors()->first(),$data);
        }

        $user = Client::where('pin_code',$request->pin_code)->where('pin_code','!=',0)
            ->where('phone',$request->phone)->first();

        if ($user)
        {
            $user->password = bcrypt($request->password);
            $user->pin_code = null;

            if ($user->save())
            {
                return responseJson(1,'تم تغيير كلمة المرور بنجاح');
            }else{
                return responseJson(0,'حدث خطأ ، حاول مرة أخرى');
            }
        }else{
            return responseJson(0,'هذا الكود غير صالح');
        }
    }

    public function notificationsSettings(Request $request)
    {
        RequestLog::create(['content' => $request->all(),'service' => 'Notifications Settings']);
        $rules = [
            'governorates.*' => 'exists:governorates,id',
            'blood_types.*' => 'exists:blood_types,id',
        ];
        // governorates == [1,5,13]
        // blood_types == [1,3]
        $validator = validator()->make($request->all(),$rules);
        if ($validator->fails())
        {
            return responseJson(0,$validator->errors()->first(),$validator->errors());
        }

        if ($request->has('governorates'))
        {
            // 1,2
            // sync (1,3,4)
            // 1,3,4
            $request->user()->governorates()->sync($request->governorates); // attach - detach() - toggle() - sync
        }

        if ($request->has('blood_types'))
        {
            $request->user()->bloodtypes()->sync($request->blood_types);
        }

        $data = [
            'governorates' => $request->user()->governorates()->pluck('governorates.id')->toArray(), // [1,3,4]
            // {name: asda , 'created' : asdasd , id: asdasd}
            // [1,5,13]
            'blood_types' => $request->user()->bloodtypes()->pluck('blood_types.id')->toArray(),
        ];
        return responseJson(1,'تم  التحديث',$data);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function registerToken(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'token' => 'required',
            'type' => 'required|in:android,ios'

        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0,$validation->errors()->first(),$data);
        }
        Token::where('token',$request->token)->delete();
        $request->user()->tokens()->create($request->all());
        return responseJson(1,'تم التسجيل بنجاح');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function removeToken(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'token' => 'required',
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0,$validation->errors()->first(),$data);
        }

        Token::where('token',$request->token)->delete();

        return responseJson(1,'تم  الحذف بنجاح بنجاح');
    }

}
