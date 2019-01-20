<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model 
{

    protected $table = 'reports';
    public $timestamps = true;
    protected $fillable = array('client_id', 'message');

    public function  client()
    {
        return $this->belongsTo('App\Models\Client');
    }
}
