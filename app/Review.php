<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use App\Like;

class Review extends Model
{
    protected $fillable = ['category_id','title', 'body', 'image'];

    public function users()
    {
      return $this->belongsTo(User::class);
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
