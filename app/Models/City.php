<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model 
{

    protected $table = 'cities';
    public $timestamps = true;
    protected $fillable = array('name', 'governorate_id');

    public function city_client()
    {
        return $this->hasMany('Client');
    }

    public function city_donation()
    {
        return $this->hasMany('DonationRequest');
    }

}