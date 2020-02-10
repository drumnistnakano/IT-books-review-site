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
        <h2 class='h2'>本のタイトル</h2>
        <p class='h2 mb20'>{{ $review->title }}</p>
        <h2 class='h2'>レビュー本文</h2>
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
    @if(Auth::user()->id == $review->user_id)
      <!--<a href="#" class='btn btn-info btn-back mb20'>編集</a>-->
      {{ Form::open(['url' => route('edit', [$review->id]), 'method'=>'GET']) }}
      {{ Form::submit('編集',['class' => 'btn btn-info btn-back mb20']) }}
      {{ Form::close() }}
      {{ Form::open(['url' => route('remove', [$review->id]), 'method'=>'POST']) }}
      {{ Form::submit('削除',['class' => 'btn btn-info btn-back mb20']) }}
      {{ Form::close() }}
    @endif
    <a href="{{ route('index') }}" class='btn btn-info btn-back mb20'>戻る</a>

    <!-- コメント投稿 -->
    <form class="mb-4" method="POST" action="{{ route('comments.store') }}">
      @csrf
      <input name="review_id" type="hidden" value="{{ $review->id }}">
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
          <p class="mt-2">
            {!! nl2br(e($comment->body)) !!}
          </p>
        </div>
      @empty
        <p>コメントはまだありません。</p>
      @endforelse
    </section>
  </div>
</div>

@endsection