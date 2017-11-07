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

//Huifang\Mobi\Http\Controllers

Route::controller('auth', 'Auth\AuthController', [
    'getLogin'  => 'user.login',
    'postLogin' => 'user.post.login',
    'getLogout' => 'user.logout',
]);

Route::get('/', ['as' => '', 'uses' => 'HomeController@home']);
Route::get('/home', ['as' => 'home', 'uses' => 'HomeController@home']);
Route::get('/product', ['as' => 'product', 'uses' => 'ProductController@product']);

Route::post('api/auth/login',
    ['as' => 'api.auth.login', 'uses' => 'Api\Auth\LoginController@login']);

Route::get('api/config',
    ['as' => 'api.config', 'uses' => 'Api\ConfigController@config']);

Route::group(['middleware' => 'token'], function () {
    Route::get('api/sale/filter-params',
        ['as' => 'api.sale.filter-params', 'uses' => 'Api\Sale\SaleController@filterParams']);

    //全部销售线索
    Route::get('api/sale/list',
        ['as' => 'api.sale.list', 'uses' => 'Api\Sale\SaleController@saleList']);

    //我的销售线索
    Route::get('api/sale/individual/list',
        ['as' => 'api.sale.individual.list', 'uses' => 'Api\Sale\SaleController@saleIndividualList']);

    //关键字搜索
    Route::get('api/sale/list/keyword',
        ['as' => 'api.sale.list.keyword', 'uses' => 'Api\Sale\SaleController@getSaleListByKeyword']);

    //关键字搜索
    Route::get('api/sale/list/keyword',
        ['as' => 'api.sale.list.keyword', 'uses' => 'Api\Sale\SaleController@getSaleListByKeyword']);

    //销售线索创建
    Route::post('/api/sale/store',
        ['as' => 'api.sale.store', 'uses' => 'Api\Sale\SaleController@saleStore']);

    //销售线索更新
    Route::post('/api/sale/update',
        ['as' => 'api.sale.update', 'uses' => 'Api\Sale\SaleController@saleUpdate']);

    //删除销售线索
    Route::post('/api/sale/delete',
        ['as' => 'api.sale.delete', 'uses' => 'Api\Sale\SaleController@saleDelete']);

    //删除销售线索
    Route::get('/api/sale/detail/{id}',
        ['as' => 'api.sale.detail', 'uses' => 'Api\Sale\SaleController@saleDetail']);

    //销售线索分配人员
    Route::get('api/sale/get-assign-users',
        ['as' => 'api.sale.get-assign-users', 'uses' => 'Api\Sale\SaleController@getSaleAssignUsers']);

    //销售线索分配人员
    Route::get('api/sale/assign-user',
        ['as' => 'api.sale.assign-user', 'uses' => 'Api\Sale\SaleController@getSaleAssignUsers']);

    //销售线索分配人员
    Route::post('api/sale/assign-user',
        ['as' => 'api.sale.assign-user', 'uses' => 'Api\Sale\SaleController@saleAssignUser']);

    //项目列表
    Route::get('api/project/list',
        ['as' => 'api.project.list', 'uses' => 'Api\Project\ProjectController@projectList']);
    Route::get('api/project/detail/{id}',
        ['as' => 'api.project.detail', 'uses' => 'Api\Project\ProjectController@projectDetail']);
    Route::get('api/project/individual/list',
        ['as' => 'api.project.individual.list', 'uses' => 'Api\Project\ProjectController@projectIndividualList']);
    Route::get('api/project/partner/list',
        ['as' => 'api.project.partner.list', 'uses' => 'Api\Project\ProjectController@projectPartnerList']);
    Route::get('api/project/filter',
        ['as' => 'api.project.filter', 'uses' => 'Api\Project\ProjectController@projectFilter']);
    Route::get('api/project/get-keyword',
        ['as' => 'api.project.get-keyword', 'uses' => 'Api\Project\ProjectController@getKeyword']);
    Route::post('api/project/store/{id}',
        ['as' => 'api.project.store', 'uses' => 'Api\Project\ProjectController@projectStore']);

    Route::post('api/project/delete',
        ['as' => 'api.project.delete', 'uses' => 'Api\Project\ProjectController@projectDelete']);

});