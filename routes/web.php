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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('/admin/users', 'UserController', ['as' => 'admin']);
Route::resource('/admin/categories', 'CategoryController', ['as' => 'admin']);

Route::get('/api/datatable/users', 'UserController@dataTable')->name('api.datatable.users');
Route::get('/api/datatable/categories', 'CategoryController@dataTable')->name('api.datatable.categories');
