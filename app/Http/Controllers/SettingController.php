<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Setting $model
     * @return \Illuminate\Http\Response
     */
    public function index(Setting $model)
    {
        if ($model->all()->count() > 0) {
            $model = Setting::find(1);
        }
        return view('settings.index', compact('model'));
    }


    public function update(Request $request)
    {
        $this->validate($request, [
            'facebook_url'  => 'url',
            'twitter_url'   => 'url',
            'instagram_url' => 'url',
            'google_url'    => 'url',
            'youtube_url'    => 'url',



        ]);
        if (Setting::all()->count() > 0) {
            Setting::find(1)->update($request->all());
        } else {
            Setting::create($request->all());
        }
        flash()->success('تم الحفظ بنجاح');
        return back();
    }

}
