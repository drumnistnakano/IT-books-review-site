<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// ログイン認証
Auth::routes();

// 初期画面
Route::get('/', 'ReviewController@index')->name('index');

// ホーム画面
Route::get('/home', 'HomeController@index')->name('home');

// ログイン後
Route::group(['middleware' => 'auth'], function () {
    // 投稿機能
    Route::get('/review', 'ReviewController@create')->name('create');
    Route::post('/review/save', 'ReviewController@save')->name('save');
    // 削除機能
    Route::post('/review/remove/{id}', 'ReviewController@remove')->name('remove');
    // 更新機能
    
    // いいね機能
    Route::post('/show/{review}/likes/{like}', 'LikesController@clear');
    Route::post('/show/{review}/likes', 'LikesController@apply');
    // 詳細画面
    Route::get('/show/{id}', 'ReviewController@show')->name('show');
    
});


