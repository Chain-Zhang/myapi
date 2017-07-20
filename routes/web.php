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


Route::get('get_users', 'TestController@get_users');

Route::group(['prefix' => 'api', 'namespace' => 'Api'], function(){
    Route::any('/', 'RouterController@index');  // API 入口
    Route::any('test', 'RouterController@test');  // API 入口
    Route::any('music', 'RouterController@music');  // API 入口
});