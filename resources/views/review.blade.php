@extends('layouts.app')

@section('content')
<h1 class='pagetitle'>レビュー投稿</h1>
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
      <form method='POST' action="{{ route('save') }}" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-body">
              <div class="form-group">
                <label>本のタイトル</label>
                <input type='text' class='form-control' name='title' placeholder='タイトルを入力'>
              </div>
              <div class="form-group">
                <select name="category_id">
                    @foreach($category as $category_id => $category_name)
                    <option value="{{ $category_id }}" @if($category_id == old('category_id')) selected @endif>
                        {{ $category_name }}
                    </option>
                    @endforeach
                </select>
              </div>
              <div class="form-group">
              <label>レビュー本文</label>
                <textarea class='description form-control' name='body' placeholder='本文を入力'></textarea>
              </div>
              <div class="form-group">
                <label for="file1">本のサムネイル</label>
                <input type="file" id="file1" name='image' class="form-control-file">
              </div>
              <input type='submit' class='btn btn-primary' value='レビューを登録'>
            </div>
        </div>
      </form>
    </div>
</div>
@endsection