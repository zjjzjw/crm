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

//Huifang\Admin\Http\Controllers

Route::get('/api/qi-niu/storage-tokens', ['uses' => 'Api\QiniuController@actionStorageTokens']);
Route::post('/api/qi-niu/create', ['uses' => 'Api\QiniuCallbackController@create']);

Route::controller('auth', 'Auth\AuthController', [
    'getLogin'  => 'user.login',
    'postLogin' => 'user.post.login',
    'getLogout' => 'user.logout',
]);

Route::get('/login', ['uses' => 'LoginController@login']);

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', ['uses' => 'HomeController@home']);
    Route::get('/home', ['uses' => 'HomeController@home']);
});


Route::group([], function () {
    Route::get('/company/detail', ['as' => 'company.detail', 'uses' => 'Company\CompanyController@detail']);

    //部门管理
    Route::get('/company/depart/index', ['as' => 'company.depart.index', 'uses' => 'Company\DepartController@index']);
    Route::get('/company/depart/edit/{id}', ['as' => 'company.depart.edit', 'uses' => 'Company\DepartController@edit']);
    Route::post('/company/depart', ['as' => 'company.depart.store', 'uses' => 'Company\DepartController@store']);
    Route::get('/company/depart/delete/{id}', ['as' => 'company.depart.delete', 'uses' => 'Company\DepartController@delete']);

    Route::post('/api/company/depart/next-level/{id}', ['as' => 'api.company.depart.next-level', 'uses' => 'Api\Company\DepartController@getNextLevel']);
    Route::post('/api/company/depart/next-depart/{id}', ['as' => 'api.company.depart.next-depart', 'uses' => 'Api\Company\DepartController@getNextDepart']);


    Route::post('/api/company/depart/store/{id}', ['as' => 'api.company.depart.store', 'uses' => 'Api\Company\DepartController@store']);
    Route::post('/api/company/depart/update/{id}', ['as' => 'api.company.depart.update', 'uses' => 'Api\Company\DepartController@update']);
    Route::post('/api/company/depart/delete/{id}', ['as' => 'api.company.depart.delete', 'uses' => 'Api\Company\DepartController@delete']);

    //角色管理
    Route::get('/company/role', ['as' => 'company.role.index', 'uses' => 'Company\RoleController@index']);
    Route::get('/company/role/edit/{id}', ['as' => 'company.role.edit', 'uses' => 'Company\RoleController@edit']);
    Route::post('/company/role', ['as' => 'company.role.store', 'uses' => 'Company\RoleController@store']);
    Route::get('/company/role/delete/{id}', ['as' => 'company.role.delete', 'uses' => 'Company\RoleController@delete']);

    //帐号管理
    Route::get('/company/user', ['as' => 'company.user.index', 'uses' => 'Company\UserController@index']);
    Route::get('/company/user/edit/{id}', ['as' => 'company.user.edit', 'uses' => 'Company\UserController@edit']);
    Route::post('/company/user', ['as' => 'company.user.store', 'uses' => 'Company\UserController@store']);
    Route::get('/company/user/data/{id}', ['as' => 'company.user.data', 'uses' => 'Company\UserController@data']);
    Route::post('/company/user/data/store', ['as' => 'company.user.data.store', 'uses' => 'Company\UserController@dataStore']);
    Route::get('/company/user/pwd/{id}', ['as' => 'company.user.pwd', 'uses' => 'Company\UserController@pwd']);
    Route::post('/company/user/pwd/store', ['as' => 'company.user.pwd.store', 'uses' => 'Company\UserController@pwdStore']);
    Route::get('/company/user/delete/{id}', ['as' => 'company.user.delete', 'uses' => 'Company\UserController@delete']);
    Route::get('/company/user/get-user-by-keyword', ['as' => 'company.user.get-user-by-keyword', 'uses' => 'Company\UserController@getUserByKeyword']);

    //产品管理
    Route::get('/company/product', ['as' => 'company.product.index', 'uses' => 'Company\ProductController@index']);
    Route::get('/company/product/edit/{id}', ['as' => 'company.product.edit', 'uses' => 'Company\ProductController@edit']);
    Route::post('/company/product', ['as' => 'company.product.store', 'uses' => 'Company\ProductController@store']);
    Route::get('/company/product/delete/{id}', ['as' => 'company.product.delete', 'uses' => 'Company\ProductController@delete']);

    //产品分类
    Route::get('/company/product/category', ['as' => 'company.product.category.index', 'uses' => 'Company\ProductCategoryController@index']);
    Route::get('/company/product/category/edit/{id}', ['as' => 'company.product.category.edit', 'uses' => 'Company\ProductCategoryController@edit']);
    Route::post('/company/product/category/store', ['as' => 'company.product.category.store', 'uses' => 'Company\ProductCategoryController@store']);
    Route::get('/company/product/category/delete/{id}', ['as' => 'company.product.category.delete', 'uses' => 'Company\ProductCategoryController@delete']);

    //竞品公司
    Route::get('/company/rival', ['as' => 'company.rival.index', 'uses' => 'Company\RivalController@index']);
    Route::get('/company/rival/edit/{id}', ['as' => 'company.rival.edit', 'uses' => 'Company\RivalController@edit']);
    Route::post('/company/rival/store', ['as' => 'company.rival.store', 'uses' => 'Company\RivalController@store']);
    Route::get('/company/rival/delete/{id}', ['as' => 'company.rival.delete', 'uses' => 'Company\RivalController@delete']);

    //销售线索管理
    Route::get('/company/sale/sale/index', ['as' => 'company.sale.sale.index', 'uses' => 'Company\Sale\SaleController@index']);
    Route::get('/company/sale/sale/edit/{id}', ['as' => 'company.sale.sale.edit', 'uses' => 'Company\Sale\SaleController@edit']);
    Route::get('/company/sale/sale/delete/{id}', ['as' => 'company.sale.sale.delete', 'uses' => 'Company\Sale\SaleController@delete']);
    Route::get('/company/sale/sale/import', ['as' => 'company.sale.sale.import', 'uses' => 'Company\Sale\SaleController@import']);
    Route::post('/company/sale/sale/import/store', ['as' => 'company.sale.sale.import.store', 'uses' => 'Company\Sale\SaleController@importStore']);
    Route::post('/company/sale/sale/store', ['as' => 'company.sale.sale.store', 'uses' => 'Company\Sale\SaleController@saleStore']);

    //楼盘数据
    Route::get('/company/sale/sale-property/index', [
        'as' => 'company.sale.sale-property.index', 'uses' => 'Company\Sale\SalePropertyController@index']);
    Route::get('/company/sale/sale-property/essential/{id}', [
        'as' => 'company.sale.sale-property.essential', 'uses' => 'Company\Sale\SalePropertyController@essential']);
    Route::get('/company/sale/sale-property/building/{id}', [
        'as' => 'company.sale.sale-property.building', 'uses' => 'Company\Sale\SalePropertyController@building']);
    Route::get('/company/sale/sale-property/data-property/{id}', [
        'as' => 'company.sale.sale-property.property', 'uses' => 'Company\Sale\SalePropertyController@property']);
    Route::get('/company/sale/sale-property/sales/{id}', [
        'as' => 'company.sale.sale-property.sales', 'uses' => 'Company\Sale\SalePropertyController@sales']);
    Route::get('/company/sale/sale-property/follow/{id}', [
        'as' => 'company.sale.sale-property.follow', 'uses' => 'Company\Sale\SalePropertyController@follow']);
    Route::get('/company/sale/sale-property/other/{id}', [
        'as' => 'company.sale.sale-property.other', 'uses' => 'Company\Sale\SalePropertyController@other']);
    //导入数据
    Route::get('/company/sale/sale-property/import', [
        'as' => 'company.sale.sale-property.import', 'uses' => 'Company\Sale\SalePropertyController@import']);

    //所属集团
    Route::get('/company/sale/developer-group/index', ['as' => 'company.sale.developer-group.index', 'uses' => 'Company\Sale\DeveloperGroupController@index']);
    Route::get('/company/sale/developer-group/edit/{id}', ['as' => 'company.sale.developer-group.edit', 'uses' => 'Company\Sale\DeveloperGroupController@edit']);
    Route::post('/api/company/sale/developer-group/store', ['as' => 'api.company.sale.developer-group.store', 'uses' => 'Api\Company\Sale\DeveloperGroupController@store']);
    Route::post('/api/company/sale/developer-group/update', ['as' => 'api.company.sale.developer-group.update', 'uses' => 'Api\Company\Sale\DeveloperGroupController@update']);
    Route::get('/api/company/sale/developer-group/delete/{id}', ['as' => 'api.company.sale.developer-group.delete', 'uses' => 'Api\Company\Sale\DeveloperGroupController@delete']);
    Route::get('/api/company/sale/developer-group/get-developer-group-by-keyword', ['as' => 'api.company.sale.developer-group.get-developer-group-by-keyword', 'uses' => 'Api\Company\Sale\DeveloperGroupController@getDeveloperGroupByKeyword']);






    //大区管理
    Route::get('/company/sale/large-area/index', ['as' => 'company.sale.large-area.index', 'uses' => 'Company\Sale\LargeAreaController@index']);
    Route::get('/company/sale/large-area/edit/{id}', ['as' => 'company.sale.large-area.edit', 'uses' => 'Company\Sale\LargeAreaController@edit']);
    Route::get('/api/company/sale/large-area/delete/{id}', ['as' => 'api.company.sale.large-area.delete', 'uses' => 'Api\Company\Sale\LargeAreaController@delete']);
    Route::post('/api/company/sale/large-area/update', ['as' => 'api.company.sale.large-area.update', 'uses' => 'Api\Company\Sale\LargeAreaController@update']);
    Route::post('/api/company/sale/large-area/store', ['as' => 'api.company.sale.large-area.store', 'uses' => 'Api\Company\Sale\LargeAreaController@store']);



    //品牌管理
    Route::get('/company/sale/brand/index', ['as' => 'company.sale.brand.index', 'uses' => 'Company\Sale\BrandController@index']);
    Route::get('/company/sale/brand/edit/{id}', ['as' => 'company.sale.brand.edit', 'uses' => 'Company\Sale\BrandController@edit']);
    Route::post('/api/company/sale/brand/store', ['as' => 'api.company.sale.brand.store', 'uses' => 'Api\Company\Sale\BrandController@store']);
    Route::post('/api/company/sale/brand/update', ['as' => 'api.company.sale.brand.update', 'uses' => 'Api\Company\Sale\BrandController@update']);
    Route::get('/api/company/sale/brand/delete/{id}', ['as' => 'api.company.sale.brand.delete', 'uses' => 'Api\Company\Sale\BrandController@delete']);
    Route::get('/api/company/sale/brand/keyword', ['as' => 'api.company.sale.brand.keyword', 'uses' => 'Api\Company\Sale\BrandController@keyword']);

    //分公司
    Route::get('/company/sale/developer/index', ['as' => 'company.sale.developer.index', 'uses' => 'Company\Sale\DeveloperController@index']);
    Route::get('/company/sale/developer/edit/{id}', ['as' => 'company.sale.developer.edit', 'uses' => 'Company\Sale\DeveloperController@edit']);
    Route::post('/api/company/sale/developer/store', ['as' => 'api.company.sale.developer.store', 'uses' => 'Api\Company\Sale\DeveloperController@store']);
    Route::post('/api/company/sale/developer/update', ['as' => 'api.company.sale.developer.update', 'uses' => 'Api\Company\Sale\DeveloperController@update']);
    Route::get('/api/company/sale/developer/delete/{id}', ['as' => 'api.company.sale.developer.delete', 'uses' => 'Api\Company\Sale\DeveloperController@delete']);

    Route::get('/api/company/sale/developer/get-developer-keyword',
        ['as' => 'api.company.sale.developer.get-developer-keyword', 'uses' => 'Api\Company\Sale\DeveloperController@getDeveloperByKeyword']);

    //楼盘数据
    Route::post('/api/company/sale/essential-store/{id}', ['as' => 'api.company.sale.essential-store', 'uses' => 'Api\Company\Sale\SalePropertyController@essentialStore']);
    Route::post('/api/company/sale/building-store/{id}', ['as' => 'api.building.sale.essential-store', 'uses' => 'Api\Company\Sale\SalePropertyController@buildingStore']);
    Route::post('/api/company/sale/property-store/{id}', ['as' => 'api.property.sale.property-store', 'uses' => 'Api\Company\Sale\SalePropertyController@propertyStore']);
    Route::post('/api/company/sale/sale-store/{id}', ['as' => 'api.property.sale.sale-store', 'uses' => 'Api\Company\Sale\SalePropertyController@saleStore']);
    Route::post('/api/company/sale/follow-store/{id}', ['as' => 'api.property.sale.follow-store', 'uses' => 'Api\Company\Sale\SalePropertyController@followStore']);
    Route::post('/api/company/sale/other-store/{id}', ['as' => 'api.property.sale.other-store', 'uses' => 'Api\Company\Sale\SalePropertyController@otherStore']);
});
