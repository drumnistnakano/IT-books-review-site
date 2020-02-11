<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Comment extends Model
{
    protected $fillable = ['body', 'user_id', 'review_id', 'display_comments'];
    
    public function review()
    {
        return $this->belongsTo('App\Review');
    }

    public function user()
    {
      return $this->belongsTo(User::class);
    }
}
