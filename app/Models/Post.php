<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Post extends Model 
{

    protected $table = 'posts';
    public $timestamps = true;
    protected $fillable = array('client_id', 'title', 'content', 'thumbnail', 'publish_date', 'category_id');
    protected $appends = array('thumbnail_full_path','is_favourite'); // getIsFavouriteAttribute()

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function getThumbnailFullPathAttribute()
    {
        return asset($this->thumbnail);
    }
    // attribute IsFavourite -> is_favourite
    // $post->is_favourite [ true - false ]
    // if($post->is_favourite)
    public function getIsFavouriteAttribute()
    {
        $user = auth()->guard('client')->user() ?? auth()->guard('api')->user();
        if (!$user)
        {
            return false;
        }
        $favourite = $this->whereHas('favourites',function ($query) use($user){
            $query->where('client_post.client_id',$user->id);
            $query->where('client_post.post_id',$this->id);
        })->first();
        // client
        // null
        if ($favourite)
        {
            return true;
        }
        return false;
    }

    public function favourites()
    {
        return $this->belongsToMany(Client::class);
    }


    public function scopeSearchByKeyword($query,$request)
    {
        $query->where(function($post) use($request){
            $post->where('title','like','%'.$request->keyword.'%');
            $post->orWhere('content','like','%'.$request->keyword.'%');
        });
    }

    public function scopePublished($query)
    {
        $query->where('publish_date','<=',Carbon::now()->toDateString());
    }

}
