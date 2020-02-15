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

// プロバイダー認証APIにリダイレクト
Route::get('/login/{provider}', 'Auth\LoginController@redirectToProvider');
// 認証APIからのコールバック後の処理
Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback');

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
    Route::get('/review/edit/{id}', 'ReviewController@edit')->name('edit');
    Route::post('/review/edit/{id}', 'ReviewController@update')->name('update');
    // いいね機能
    Route::post('/show/{review}/likes/{like}', 'LikesController@clear');
    Route::post('/show/{review}/likes', 'LikesController@apply');
    // コメント投稿
    Route::post('/comment', 'CommentsController@store')->name('comments.store');
    Route::post('/comment/{id}/flag', 'CommentsController@canComment');
    // 詳細画面
    Route::get('/show/{id}', 'ReviewController@show')->name('show');
    
});


