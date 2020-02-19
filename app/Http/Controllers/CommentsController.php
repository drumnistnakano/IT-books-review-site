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

        // コメント本文、レビュー詳細ページのURLをLineで通知
        if($review->user->provider_user_id){
            $this->notifyLine($review->user->provider_user_id, "あなたのレビューにコメントが投稿されました");
            $this->notifyLine($review->user->provider_user_id, $request->body);
            $this->notifyLine($review->user->provider_user_id, url('show'.'/'.$request->review_id));
        }

        return redirect()
             ->action('ReviewController@show', $review->id);
    }

    public function canComment(Request $request, $id){
        $review = Review::findOrFail($id);
        $review->display_comments = $request->display_comments;
        $review->save();

        return redirect()
             ->action('ReviewController@show', $review->id);
    }

    // Line Push APIで通知
    private function notifyLine($id, $text){
        $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(env('LINE_ACCESS_TOKEN'));
        $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => env('LINE_CHANNEL_SECRET')]);

        $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($text);
        $response = $bot->pushMessage($id, $textMessageBuilder);
    }
}
