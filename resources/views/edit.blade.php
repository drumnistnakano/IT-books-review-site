@extends('layouts.app')

@section('css')
    <link href="{{ asset('css/show.css') }}" rel="stylesheet">
@endsection

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="row justify-content-center container">
  <div class="col-md-10">
    <form method='POST' action="{{ route('update', ['id' => $review->id ]) }}" enctype="multipart/form-data">
      @csrf
      <div class="card">
          <div class="card-body">
            <div class="form-group">
              <select name="category_id">
                  @foreach($category as $category_id => $category_name)
                  <option value="{{ $category_id }}" @if($category_id == $select_category->id) selected @endif>
                      {{ $category_name }}
                  </option>
                  @endforeach
              </select>
            </div>
            <div class="form-group">
              <label>本のタイトル</label>
              <input type='text' class='form-control' name='title' placeholder='タイトルを入力' value="{{ $review->title }}">
            </div>
            <div class="form-group">
            <label>レビュー本文</label>
              <textarea class='description form-control' name='body' placeholder='本文を入力'>{{ $review->body }}</textarea>
            </div>
            <div class="form-group">
              <label for="file1">本のサムネイル</label>
              <input type="file" id="file1" name='image' class="form-control-file">
              <input type="hidden" name="img" value={{$review->image}}>
            </div>
            <input type='submit' class='btn btn-primary' value='更新'>
          </div>
      </div>
    </form>
  </div>
</div>


@endsection