<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Client extends Authenticatable
{

    protected $table = 'clients';
    public $timestamps = true;
    protected $fillable = array('name', 'email', 'birth_date', 'city_id','blood_type', 'phone',
        'password', 'is_active','donation_last_date','pin_code');

    public function requests()
    {
        return $this->hasMany('App\Models\DonationRequest');
    }

    public function notifications()
    {
        return $this->belongsToMany('App\Models\Notification')->withPivot('is_read');
    }

    public function favourites()
    {
        return $this->belongsToMany('App\Models\Post');
    }

    public function reports()
    {
        return $this->hasMany('App\Models\Report');
    }

    public function contacts()
    {
        return $this->hasMany('App\Models\Contact');
    }

    public function bloodTypes()
    {
        return $this->belongsToMany('App\Models\BloodType');
    }

    public function cities()
    {
        return $this->belongsToMany('App\Models\City');
    }


    public function tokens()
    {
        return $this->hasMany('App\Models\Token');
    }

    protected $hidden = [
        'password','api_token'
    ];

}