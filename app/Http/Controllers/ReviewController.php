<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Review;

class ReviewController extends Controller
{
    public function index(){
        // 作成日時降順でレビューを取得
        $reviews = Review::where('status', 1)->orderBy('created_at', 'DESC')->paginate(6);
        return view('index', compact('reviews'));
    }
    
    public function create(){
        return view('review');
    }
    
    public function save(Request $request){
        $r = $request->all();
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
            'image' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $request->file('image')->store('/public/images');
            $data = [
                'user_id' => \Auth::id(), 
                'title' => $r['title'], 
                'body' => $r['body'], 
                'image' => $request->file('image')->hashName() // 保存する画像名をハッシュで変換
            ];
        } else {
            $data = [
                'user_id' => \Auth::id(), 
                'title' => $r['title'], 
                'body' => $r['body']
            ];
        }
        
        Review::insert($data);
        return redirect('/')->with('message', '投稿しました');
    }
    
    public function show($id)
    {
        $review = Review::where('id', $id)->where('status', 1)->first();
        return view('show', compact('review'));
    }
}
