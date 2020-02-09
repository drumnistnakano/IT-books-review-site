<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Review;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index(){
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
                // 保存する画像名をハッシュで変換
                'image' => $request->file('image')->hashName()
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
        $like = $review->likes()->where('user_id', Auth::user()->id)->first();
        return view('show', compact('review', 'like'));
    }
    
    public function remove($id)
    {
        $review = Review::find($id);
        $review->delete();
        return redirect('/');
    }
    
    public function edit($id)
    {
        $review= Review::findOrFail($id);
        return view('edit', compact('review'));
    }
    
    public function update(Request $request, $id){
        $review = Review::findOrFail($id);
        $review->category_id = $request->category_id;
        $review->title = $request->title;
        $review->body = $request->body;
        $review->save();      
        
        return redirect()
             ->action('ReviewController@show', $review->id);
    }
}
