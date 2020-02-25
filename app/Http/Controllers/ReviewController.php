<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Review;
use App\Category;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    public function index(){
        $reviews = Review::where('status', 1)->orderBy('created_at', 'DESC')->paginate(6);
        return view('index', compact('reviews'));
    }
    
    public function create(){
        $category = Category::orderBy('id', 'asc')->pluck('name', 'id');
        return view('review', compact('category'));
    }
    
    // TODO : バリデーションの切り出し
    public function save(Request $request){
        $r = $request->all();
        // バリデーション
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
            'image' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // 画像添付有
        if ($request->hasFile('image')) {
            $file_path = Storage::disk('s3')->putFile('images', $request->file('image'), 'public');
            $data = [
                'user_id' => \Auth::id(), 
                'title' => $r['title'], 
                'category_id' => $r['category_id'],
                'body' => $r['body'], 
                'image' => Storage::disk('s3')->url($file_path)
            ];
        }
        // 画像添付無
        else {
            $data = [
                'user_id' => \Auth::id(), 
                'title' => $r['title'], 
                'category_id' => $r['category_id'],
                'body' => $r['body']
            ];
        }
        
        Review::insert($data);
        return redirect()->route('index')->with('message', '投稿しました');
    }
    
    public function show($id)
    {
        $loginuser = \Auth::user();

        $review = Review::where('id', $id)->where('status', 1)->first();
        $like = $review->likes()->where('user_id', $loginuser->id)->first();
        return view('show', compact('review', 'like', 'loginuser'));
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
        $category = Category::orderBy('id', 'asc')->pluck('name', 'id');
        $select_category = Category::where('id', $review->category_id)->first();
        return view('edit', compact('review', 'category', 'select_category'));
    }
    
    // TODO : バリデーションの切り出し
    public function update(Request $request, $id){
        // バリデーション
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
            'image' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $review = Review::findOrFail($id);
        $review->category_id = $request->category_id;
        $review->title = $request->title;
        $review->body = $request->body;
        // ファイルが存在する場合にS3に保存
        if ($request->hasFile('image')) {
            $file_path = Storage::disk('s3')->putFile('images', $request->file('image'), 'public');
            $review->image = Storage::disk('s3')->url($file_path);
        }

        $review->save();
        
        return redirect()
             ->action('ReviewController@show', $review->id);
    }
}
