@extends('layouts.app')

@section('css')
    <link href="{{ asset('css/show.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
  <h1 class='pagetitle'>レビュー詳細</h1>
  <div class="card">
    <div class="card-body d-flex">
      <section class='review-main'>
        <h2 class='h4'>カテゴリ</h2>
        <div class="btn mb20" style="background-color:{{ $review->category->color }}">
          {{ $review->category->name }}
        </div>
        <h2 class='h4'>タイトル</h2>
        <p class='h5 mb20'>{{ $review->title }}</p>
        <h2 class='h4'>レビュー内容</h2>
        <p>{{ $review->body }}</p>
      </section>  
      <aside class='review-image'>
          @if(!empty($review->image))
          <img class='book-image' src="{{ asset('storage/images/'.$review->image) }}">
          @else
          <img class='book-image' src="{{ asset('images/dummy.png') }}">
          @endif
      </aside>
    </div>
    @if (Auth::check())
      @if ($like)
        <!-- いいね取り消しフォーム -->
        {{ Form::model($review, array('action' => array('LikesController@clear', $review->id, $like->id))) }}
          <button type="submit" class="btn btn-outline-danger rounded-pill">
            いいね 
            <i class="fas fa-heart"></i>
          </button>
          <div class="balloon">    
            <span class="number">{{ $review->likes_count }}</span>    
          </div>
        {!! Form::close() !!}
      @else
        <!-- いいねフォーム -->
        {{ Form::model($review, array('action' => array('LikesController@apply', $review->id))) }}
          <button type="submit" class="btn page-link text-dark d-inline-block rounded-pill">
            いいね
            <i class="far fa-heart"></i>
          </button>
          <div class="balloon">    
            <span class="number">{{ $review->likes_count }}</span>    
          </div>
        {!! Form::close() !!}
      @endif
    @endif
    <div class="form-inline">
    @if(Auth::user()->id == $review->user_id)
      <div class="form-group">
        {{ Form::open(['url' => route('edit', [$review->id]), 'method'=>'GET']) }}
        {{ Form::submit('編集',['class' => 'btn btn-success mb20']) }}
        {{ Form::close() }}
        {{ Form::open(['url' => route('remove', [$review->id]), 'method'=>'POST']) }}
        {{ Form::submit('削除',['class' => 'btn btn-danger mb20']) }}
        {{ Form::close() }}
      </div>
    @endif
    <a href="{{ route('index') }}" class='btn btn-info mb20'>戻る</a>
    </div>

    <!-- コメント表示・非表示ボタン -->
    @if(Auth::user()->id == $review->user_id)
    <form action="{{ action('CommentsController@canComment', $review->id)}}" method="POST" name="display">
    @csrf
    <div class="btn-group btn-group-toggle" data-toggle="buttons">
      <label class="btn btn-outline-secondary  active">
        <input type="radio" name="display_comments" id="option1" value="1" autocomplete="off" @if($review->display_comments === 1) checked @endif> コメント表示
      </label>
      <label class="btn btn-outline-secondary">
        <input type="radio" name="display_comments" id="option2" value="0" autocomplete="off" @if($review->display_comments === 0) checked @endif> コメント非表示
      </label>
    </div>
    </form>
    @endif

    <!-- 表示フラグ(1:表示, 0:非表示)によってコメント欄のの表示が切り替わる -->
    @if($review->display_comments === 1)

    <!-- コメント投稿 -->
    <form class="mb-4" method="POST" action="{{ route('comments.store') }}">
      @csrf
      <input name="review_id" type="hidden" value="{{ $review->id }}">
      <input name="user_id" type="hidden" value="{{ $loginuser->id }}">
      <div class="form-group">
        <label for="body">コメント</label>
        <textarea id="body" name="body" class="form-control {{ $errors->has('body') ? 'is-invalid' : '' }}" rows="4">
          {{ old('body') }}
        </textarea>
        @if ($errors->has('body'))
            <div class="invalid-feedback">
                {{ $errors->first('body') }}
            </div>
        @endif
      </div>

      <div class="mt-4">
        <button type="submit" class="btn btn-primary">
            コメントする
        </button>
      </div>
    </form>

    <!-- コメント一覧 -->
    <section>
      <hr />
      <h2 class="h5 mb-4">コメント一覧</h2>

      @forelse($review->comments as $comment)
        <div class="border-top p-4">
          <time class="text-secondary">
            {{ $comment->created_at->format('Y.m.d H:i') }}
          </time>
          <spen>
            {{ $comment->user->name }}
          </spen>
          <p class="mt-2">
            {!! nl2br(e($comment->body)) !!}
          </p>
        </div>
      @empty
        <p>コメントはまだありません。</p>
      @endforelse
    </section>
    @endif
  </div>
</div>

@endsection

<!-- TODO : jsファイルに切り出し -->
<script type="text/javascript" language="javascript">
  window.onload = function() {
    var btn = document.getElementsByName('display_comments');
    btn.forEach(function(e) {
        e.addEventListener("click", function() {
            document.display.submit();
        });
    });
  };

</script>