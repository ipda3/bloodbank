<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonationRequest extends Model 
{

    protected $table = 'donation_requests';
    public $timestamps = true;
    protected $fillable = array('client_id', 'patient_name', 'patient_age', 'blood_type', 'bags_num', 'hospital_name', 'hospital_address', 'city_id', 'phone', 'notes', 'latitude', 'longitude');

    public function notification()
    {
        return $this->hasMany('Notification');
    }

}