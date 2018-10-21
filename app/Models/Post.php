<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model 
{

    protected $table = 'posts';
    public $timestamps = true;
    protected $fillable = array('client_id', 'title', 'content', 'thumbnail', 'publish_date', 'category_id');
    protected $appends = array('thumbnail_full_path');

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function getThumbnailFullPathAttribute()
    {
        return asset($this->thumbnail);
    }

    public function hasFav()
    {
        return $this->hasMany('ArticleClient');
    }

}