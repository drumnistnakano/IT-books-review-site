<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use App\Like;
use App\Category;

class Review extends Model
{
    protected $fillable = ['category_id','title', 'body', 'image'];

    public function user()
    {
      return $this->belongsTo(User::class);
    }

    public function category()
    {
      return $this->belongsTo('App\Category');
    }

    public function likes()
    {
      return $this->hasMany('App\Like');
    }

    public function like_by()
    {
      return Like::where('user_id', Auth::user()->id)->first();
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
}
