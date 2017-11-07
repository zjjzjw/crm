<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Huifang\Site\Http\Controllers

Route::controller('auth', 'Auth\AuthController', [
    'getLogin'  => 'user.login',
    'postLogin' => 'user.post.login',
    'getLogout' => 'user.logout',
]);

Route::get('/', ['as' => '', 'uses' => 'HomeController@home']);
Route::get('/home', ['as' => 'home', 'uses' => 'HomeController@home']);
Route::get('/product', ['as' => 'product', 'uses' => 'ProductController@product']);
