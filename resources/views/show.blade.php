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
        {{ Form::model($review, array('action' => array('LikesController@destroy', $review->id, $like->id))) }}
          <button type="submit">
            ♡ いいね {{ $review->likes_count }}
          </button>
        {!! Form::close() !!}
      @else
        <!-- いいねフォーム -->
        {{ Form::model($review, array('action' => array('LikesController@store', $review->id))) }}
          <button type="submit">
            + いいね {{ $review->likes_count }}
          </button>
        {!! Form::close() !!}
      @endif
    @endif
    <a href="{{ route('index') }}" class='btn btn-info btn-back mb20'>戻る</a>
  </div>
</div>

@endsection