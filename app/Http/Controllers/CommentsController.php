<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Review;
use Auth;

class CommentsController extends Controller
{
    public function store(Request $request)
    {
        $params = $request->validate([
            'review_id' => 'required|exists:reviews,id',
            'body' => 'required|max:2000',
            'user_id' =>'required|exists:users,id'
        ]);

        $review = Review::findOrFail($params['review_id']);
        $review->comments()->create($params);

        return redirect()
             ->action('ReviewController@show', $review->id);
    }
}
