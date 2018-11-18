<?php

namespace App\Http\Controllers\Api;

use App\Models\BloodType;
use App\Models\Client;
use App\Models\RequestLog;
use App\Models\Token;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
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
        $client->cities()->attach($request->city_id);
        $bloodType = BloodType::where('name',$request->blood_type)->first();
        $client->bloodTypes()->attach($bloodType->id);
        return responseJson(1,'تم الاضافة بنجاح',[
            'api_token' => $client->api_token,
            'client' => $client
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
        $validation = validator()->make($request->all(), [
            'password' => 'confirmed',
            'email' => Rule::unique('clients')->ignore($request->user()->id),
            'phone' => Rule::unique('clients')->ignore($request->user()->id),
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0,$validation->errors()->first(),$data);
        }

        $loginUser = $request->user();

        $loginUser->update($request->all());


        if ($request->has('password'))
        {
            $loginUser->password = bcrypt($request->password);
        }

        $loginUser->save();

        if ($request->has('city_id'))
        {
            $loginUser->cities()->detach($request->city_id);
            $loginUser->cities()->attach($request->city_id);
        }

        if ($request->has('blood_type'))
        {

            $bloodType = BloodType::where('name',$request->blood_type)->first();
            $loginUser->bloodTypes()->detach($bloodType->id);
            $loginUser->bloodTypes()->attach($bloodType->id);
        }

        $data = [
            'user' => $request->user()->fresh()->load('carModel','photos','trustIcons')
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
                // send email
//                Mail::send('emails.reset', ['code' => $code], function ($mail) use($user) {
//                    $mail->from('app.mailing.test@gmail.com', 'تطبيق باب رزق');
//
//                    $mail->to($user->email, $user->name)->subject('إعادة تعيين كلمة المرور');
//                });

                return responseJson(1,'برجاء فحص هاتفك',['pin_code_for_test' => $code]);
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
            'password' => 'confirmed'
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0,$validation->errors()->first(),$data);
        }

        $user = Client::where('pin_code',$request->pin_code)->where('pin_code','!=',0)->first();

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
            'cities.*' => 'exists:cities,id',
            'blood_types.*' => 'exists:blood_types,name',
        ];
        $validator = validator()->make($request->all(),$rules);
        if ($validator->fails())
        {
            return responseJson(0,$validator->errors()->first(),$validator->errors());
        }

        if ($request->has('cities'))
        {
            $request->user()->cities()->sync($request->cities);
        }

        if ($request->has('blood_types'))
        {
            $blood_types = BloodType::whereIn('name',$request->blood_types)->pluck('blood_types.id')->toArray();
            $request->user()->bloodTypes()->sync($request->$blood_types);
        }

        $data = [
            'cities' => $request->user()->cities()->pluck('cities.id')->toArray(),
            'bloodTypes' => $request->user()->bloodTypes()->pluck('blood_types.name')->toArray(),
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
            'platform' => 'required|in:android,ios'

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
