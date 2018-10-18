<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model 
{

    protected $table = 'posts';
    public $timestamps = true;
    protected $fillable = array('client_id', 'title', 'content', 'thumbnail', 'publish_date', 'category_id');

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function hasFav()
    {
        return $this->hasMany('ArticleClient');
    }

}