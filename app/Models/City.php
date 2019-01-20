<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model 
{

    protected $table = 'cities';
    public $timestamps = true;
    protected $fillable = array('name', 'governorate_id');


    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function donations()
    {
        return $this->hasMany(DonationRequest::class);
    }

    public function governorate()
    {
        return $this->belongsTo('App\Models\Governorate');
    }

    public function city()
    {
        return $this->belongsToMany('App\Models\City');
    }

}
