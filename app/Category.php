<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Review;

class Category extends Model
{
    public function reviews()
    {
      return $this->hasMany('App\Review');
    }
}
