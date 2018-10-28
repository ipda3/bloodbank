<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestLog extends Model
{

    protected $table = 'logs';
    public $timestamps = true;
    protected $fillable = array('content', 'service');

    public function setContentAttribute($value)
    {
        $this->attributes['content'] = json_encode($value);
    }

    public function getContentAttribute($value)
    {
        return json_decode($value);
    }

}