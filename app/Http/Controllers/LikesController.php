<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use App\Review;
use App\Like;


class LikesController extends Controller
{
    public function store(Request $request, $reviewId)
    {
        Like::create(
          array(
            'user_id' => Auth::user()->id,
            'review_id' => $reviewId
          )
        );

        $review = Review::findOrFail($reviewId);

        return redirect()
             ->action('ReviewController@show', $review->id);
    }

    public function destroy($reviewId, $likeId) {
      $review = Review::findOrFail($reviewId);
      $review->like_by()->findOrFail($likeId)->delete();

      return redirect()
             ->action('ReviewController@show', $review->id);
    }
}
