<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonationRequest extends Model 
{

    protected $table = 'donation_requests';
    public $timestamps = true;
    protected $fillable = array('client_id', 'patient_name', 'patient_age', 'blood_type_id', 'bags_num', 'hospital_name', 'hospital_address', 'city_id', 'phone', 'notes', 'latitude', 'longitude');

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function bloodType()
    {
        return $this->belongsTo('App\Models\BloodType');
    }

}
