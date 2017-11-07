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

//Huifang\Crm\Http\Controllers
Route::get('/api/qi-niu/storage-tokens', ['uses' => 'Api\QiniuController@actionStorageTokens']);

Route::group(['prefix' => '/api/qiniu'], function () {
    Route::post('create', 'Api\QiniuCallbackController@create');
    Route::get('index', 'Api\QiniuCallbackController@index');
});

Route::controller('auth', 'Auth\AuthController', [
    'getLogin'  => 'user.login',
    'postLogin' => 'user.post.login',
    'getLogout' => 'user.logout',
]);

Route::get('/login', ['uses' => 'LoginController@login']);

Route::group(['middleware' => 'auth'], function () {

    Route::get('/', ['uses' => 'HomeController@home']);
    Route::get('/home', ['uses' => 'HomeController@home']);

    Route::get('/company', ['as' => 'company.index', 'uses' => 'Company\CompanyController@index']);

    Route::post('/company', ['as' => 'company.store', 'uses' => 'Company\CompanyController@store']);
    Route::get('/company/edit/{id}', ['as' => 'company.edit', 'uses' => 'Company\CompanyController@edit']);

    //部门管理
    Route::get('/company/{company_id}/depart', ['as' => 'company.depart.index', 'uses' => 'Company\DepartController@index']);
    Route::get('/company/{company_id}/depart/edit/{id}', ['as' => 'company.depart.edit', 'uses' => 'Company\DepartController@edit']);
    Route::post('/company/depart', ['as' => 'company.depart.store', 'uses' => 'Company\DepartController@store']);

    //角色管理
    Route::get('/company/{company_id}/role', ['as' => 'company.role.index', 'uses' => 'Company\RoleController@index']);
    Route::get('/company/{company_id}/role/edit/{id}', ['as' => 'company.role.edit', 'uses' => 'Company\RoleController@edit']);
    Route::post('/company/role', ['as' => 'company.role.store', 'uses' => 'Company\RoleController@store']);

    //帐号管理
    Route::get('/company/{company_id}/user', ['as' => 'company.user.index', 'uses' => 'Company\UserController@index']);
    Route::get('/company/{company_id}/user/edit/{id}', ['as' => 'company.user.edit', 'uses' => 'Company\UserController@edit']);
    Route::post('/company/user', ['as' => 'company.user.store', 'uses' => 'Company\UserController@store']);
    Route::get('/company/{company_id}/user/data/{id}', ['as' => 'company.user.data', 'uses' => 'Company\UserController@data']);
    Route::post('company/user/data/store', ['as' => 'company.user.data.store', 'uses' => 'Company\UserController@dataStore']);
    Route::get('/company/{company_id}/user/pwd/{id}', ['as' => 'company.user.pwd', 'uses' => 'Company\UserController@pwd']);
    Route::post('/company/user/pwd/store', ['as' => 'company.user.pwd.store', 'uses' => 'Company\UserController@pwdStore']);

    //产品管理
    Route::get('/company/{company_id}/product', ['as' => 'company.product.index', 'uses' => 'Company\ProductController@index']);
    Route::get('/company/{company_id}/product/edit/{id}', ['as' => 'company.product.edit', 'uses' => 'Company\ProductController@edit']);
    Route::post('/company/product', ['as' => 'company.product.store', 'uses' => 'Company\ProductController@store']);

    //系统公告
    Route::get('/publicity', ['as' => 'publicity.index', 'uses' => 'PublicityController@index']);
    Route::get('/publicity/edit/{id}', ['as' => 'publicity.edit', 'uses' => 'PublicityController@edit']);
    Route::post('/publicity', ['as' => 'publicity.store', 'uses' => 'PublicityController@store']);

    //意见反馈
    Route::get('/suggestion', ['as' => 'suggestion.index', 'uses' => 'SuggestionController@index']);
    Route::get('/suggestion/edit/{id}', ['as' => 'suggestion.edit', 'uses' => 'SuggestionController@edit']);

});

