<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use kanazaca\CounterCache\CounterCache;
use App\User;

class Like extends Model
{
    use CounterCache;

    public $counterCacheOptions = [
        'Review' => [
            'field' => 'likes_count',
            'foreignKey' => 'review_id'
        ]
    ];

    protected $fillable = ['user_id', 'review_id'];

    public function Review()
    {
      return $this->belongsTo('\App\Review');
    }

    public function User()
    {
      return $this->belongsTo(User::class);
    }
}
