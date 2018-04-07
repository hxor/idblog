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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('/admin/users', 'UserController', ['as' => 'admin']);
Route::resource('/admin/categories', 'CategoryController', ['as' => 'admin']);
Route::resource('/admin/posts', 'PostController', ['as' => 'admin']);

Route::get('/admin/settings/', 'SettingController@index')->name('admin.settings.index');
Route::post('/admin/settings/', 'SettingController@store')->name('admin.settings.store');

Route::get('/api/datatable/users', 'UserController@dataTable')->name('api.datatable.users');
Route::get('/api/datatable/categories', 'CategoryController@dataTable')->name('api.datatable.categories');
Route::get('/api/datatable/posts', 'PostController@dataTable')->name('api.datatable.posts');
