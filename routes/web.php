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

Route::get('/', 'IndexController@index');
Route::get('/blog', 'IndexController@blog');
Route::get('/blog/{slug}', 'IndexController@show');

Route::post('/blog/{slug}/comment', 'IndexController@comment')->name('post.comment');

Route::get('/blog/category/{slug}', 'IndexController@blogCategory');

Route::get('/search', 'IndexController@blogSearch');

Auth::routes();

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'auth'], function() {
    Route::get('/', 'HomeController@index')->name('index');

    Route::resource('/users', 'UserController');
    Route::resource('/categories', 'CategoryController');
    Route::resource('/posts', 'PostController');
    Route::resource('/comments', 'CommentController', ['except' => ['create', 'store']]);

    Route::get('/settings', 'SettingController@index')->name('settings.index');
    Route::post('/settings', 'SettingController@store')->name('settings.store');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/api/datatable/users', 'UserController@dataTable')->name('api.datatable.users');
    Route::get('/api/datatable/categories', 'CategoryController@dataTable')->name('api.datatable.categories');
    Route::get('/api/datatable/posts', 'PostController@dataTable')->name('api.datatable.posts');
    Route::get('/api/datatable/comments', 'CommentController@dataTable')->name('api.datatable.comments');
});
