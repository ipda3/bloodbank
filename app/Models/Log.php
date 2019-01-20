<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Log extends Controller
{
    
    protected $table = 'logs';
    public $timestamps = true;
    protected $fillable = array('id','content','service');
}
