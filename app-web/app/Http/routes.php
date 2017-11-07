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

Route::controller('auth', 'Auth\AuthController', [
    'getLogin'  => 'user.login',
    'postLogin' => 'user.post.login',
    'getLogout' => 'user.logout',
]);

Route::get('/login', ['uses' => 'LoginController@login']);
Route::get('/error', ['uses' => 'LoginController@error']);

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', ['as' => 'home', 'uses' => 'HomeController@home']);
    Route::get('/home', ['as' => 'home', 'uses' => 'HomeController@home']);
});

//消息
Route::group(['middleware' => 'auth'], function () {
    Route::get('/message/index', ['as' => 'message.index', 'uses' => 'MessageController@messageIndex']);
    //消息列表
    Route::get('/message/list/{type}', ['as' => 'message.list', 'uses' => 'MessageController@messageList']);
    //消息详情
    Route::get('/message/detail/{id}', ['as' => 'message.detail', 'uses' => 'MessageController@messageDetail']);
});


//销售管理
Route::group(['middleware' => ['auth', 'role']], function () {
    //全部销售线索
    Route::get('/sale/list',
        ['as' => 'sale.list', 'uses' => 'SaleController@saleList']);
    //我的销售线索
    Route::get('/sale/individual/list',
        ['as' => 'sale.individual.list', 'uses' => 'SaleController@saleIndividualList']);
    //销售管理详情
    Route::get('/sale/detail/{id}',
        ['as' => 'sale.detail', 'uses' => 'SaleController@saleDetail']);
    //销售管理创建
    Route::get('/sale/edit/{id}',
        ['as' => 'sale.edit', 'uses' => 'SaleController@saleEdit']);

    //销售线索API
    //全部销售线索列表
    Route::get('/api/sale/list',
        ['as' => 'api.sale.list', 'uses' => 'Api\SaleController@saleList']);
    //我的销售线索列表
    Route::get('/api/sale/individual/list',
        ['as' => 'api.sale.individual.list', 'uses' => 'Api\SaleController@saleIndividualList']
    );
    //关键字搜索
    Route::get('/api/sale/list/keyword',
        ['as' => 'api.sale.list.keyword', 'uses' => 'Api\SaleController@getSaleListByKeyword']);
    //销售线索保存
    Route::post('/api/sale/store',
        ['as' => 'api.sale.store', 'uses' => 'Api\SaleController@saleStore']);
    //销售线索分配
    Route::post('/api/sale/assign/user',
        ['as' => 'api.sale.assign.user', 'uses' => 'Api\SaleController@saleAssignUser']);
    //认领销售线索
    Route::post('/api/sale/claim',
        ['as' => 'api.sale.claim', 'uses' => 'Api\SaleController@saleClaim']);
    //删除销售线索
    Route::post('/api/sale/delete/{id}',
        ['as' => 'api.sale.delete', 'uses' => 'Api\SaleController@saleDelete']);

    //删除销售线索
    Route::post('/api/sale/audit',
        ['as' => 'api.sale.audit', 'uses' => 'Api\SaleController@saleAudit']);
});


//项目管理
Route::group(['middleware' => ['auth', 'role']], function () {
    //全部项目
    Route::get('/project/list',
        ['as' => 'project.list', 'uses' => 'Project\ProjectController@projectList']);
    //我的项目
    Route::get('/project/individual/list',
        ['as' => 'project.individual.list', 'uses' => 'Project\ProjectController@projectIndividualList']);
    //合伙项目
    Route::get('/project/partner/list',
        ['as' => 'project.partner.list', 'uses' => 'Project\ProjectController@projectPartnerList']);

    //项目管理详情
    Route::get('/project/detail/{id}',
        ['as' => 'project.detail', 'uses' => 'Project\ProjectController@projectDetail']);
    //项目编辑
    Route::get('/project/edit/{id}',
        ['as' => 'project.edit', 'uses' => 'Project\ProjectController@projectEdit']);

    //Api
    //项目全部列表
    Route::get('/api/project/list',
        ['as' => 'api.project.list', 'uses' => 'Api\Project\ProjectController@projectList']);
    //项目我的列表
    Route::get('/api/project/individual/list',
        ['as' => 'api.project.individual.list', 'uses' => 'Api\Project\ProjectController@projectIndividualList']);
    //合伙项目列表
    Route::get('/api/project/partner/list',
        ['as' => 'api.project.partner.list', 'uses' => 'Api\Project\ProjectController@projectPartnerList']);
    //项目关键字搜索
    Route::get('/api/project/list/keyword',
        ['as' => 'api.project.list.keyword', 'uses' => 'Api\Project\ProjectController@getProjectListByKeyword']);
    //项目保存
    Route::post('/api/project/store',
        ['as' => 'api.project.store', 'uses' => 'Api\Project\ProjectController@projectStore']);
    //项目删除
    Route::post('/api/project/delete/{id}',
        ['as' => 'api.project.delete', 'uses' => 'Api\Project\ProjectController@projectDelete']);


    //首页内容
    //任务清单
    Route::get('/project/task-manifest', ['as' => 'project.task-manifest', 'uses' => 'Project\ProjectController@projectTaskManifest']);
    //任务列表
    Route::get('/project/task-manifest-list/{user_id}', ['as' => 'project.task-manifest-list', 'uses' => 'Project\ProjectController@projectTaskManifestList']);
    //任务详情
    Route::get('/project/task-manifest-detail/{user_id}', ['as' => 'project.task-manifest-detail', 'uses' => 'Project\ProjectController@projectTaskManifestDetail']);


    //项目档案
    Route::group([], function () {

        //项目档案详情
        Route::get('/project/{project_id}/file',
            ['as' => 'project.file', 'uses' => 'Project\FileController@file']);

        //项目档案详情
        Route::get('/project/{project_id}/file/detail/{id}',
            ['as' => 'project.file.detail', 'uses' => 'Project\FileController@fileDetail']);
        //项目档案编辑
        Route::get('/project/{project_id}/file/edit/{id}',
            ['as' => 'project.file.edit', 'uses' => 'Project\FileController@fileEdit']);

        //API
        //保存项目档案
        Route::post('/api/project/file/store',
            ['as' => 'api.project.file.store', 'uses' => 'Api\Project\FileController@projectFileStore']);
        //删除项目档案
        Route::post('/api/project/file/delete/{id}',
            ['as' => 'api.project.file.delete', 'uses' => 'Api\Project\FileController@projectFileDelete']);

    });


    //采购流程
    Route::group([], function () {
        //采购流程
        Route::get('/project/{project_id}/flow/list',
            ['as' => 'project.purchase.list', 'uses' => 'Project\PurchaseController@flowList'])
            ->where('project_id', '[0-9]+');
        //采购流程详情
        Route::get('/project/{project_id}/flow/detail/{id}',
            ['as' => 'project.purchase.detail', 'uses' => 'Project\PurchaseController@flowDetail'])
            ->where('project_id', '[0-9]+')->where('id', '[0-9]+');
        //采购流程编辑
        Route::get('/project/{project_id}/flow/edit/{id}',
            ['as' => 'project.purchase.edit', 'uses' => 'Project\PurchaseController@flowEdit'])
            ->where('project_id', '[0-9]+')->where('id', '[0-9]+');

        //采购流程保存
        Route::post('/api/project/purchase/store',
            ['as' => 'api.project.purchase.store', 'uses' => 'Api\Project\PurchaseController@projectPurchaseStore']);
        //采购流程删除
        Route::post('/api/project/purchase/delete/{id}',
            ['as' => 'api.project.purchase.delete', 'uses' => 'Api\Project\PurchaseController@projectPurchaseDelete']);
    });

    //项目目标设置
    Route::group([], function () {
        //目标设置
        Route::get('/project/{project_id}/aim/main',
            ['as' => 'project.aim.main', 'uses' => 'Project\AimController@aimMain']);
        //目标列表
        Route::get('/project/{project_id}/aim/list',
            ['as' => 'project.aim.list', 'uses' => 'Project\AimController@aimList']);
        //目标编辑
        Route::get('/project/{project_id}/aim/edit/{id}',
            ['as' => 'project.aim.edit', 'uses' => 'Project\AimController@aimEdit']);
        //目标详情
        Route::get('/project/{project_id}/aim/detail/{id}',
            ['as' => 'project.aim.detail', 'uses' => 'Project\AimController@aimDetail']);

        //目标障碍
        Route::get('/project/{project_id}/aim/{aim_id}/hinder/list',
            ['as' => 'project.aim.hinder.list', 'uses' => 'Project\AimController@hinderList']);
        //目标障碍编辑
        Route::get('/project/{project_id}/aim/{aim_id}/hinder/edit/{id}',
            ['as' => 'project.aim.hinder.edit', 'uses' => 'Project\AimController@hinderEdit']);
        //目标障碍详情
        Route::get('/project/{project_id}/aim/{aim_id}/hinder/detail/{id}',
            ['as' => 'project.aim.hinder.detail', 'uses' => 'Project\AimController@hinderDetail']);

        //销售进度
        Route::get('/project/{project_id}/aim/progress',
            ['as' => 'project.aim.progress', 'uses' => 'Project\AimController@aimProgress']);

        //Api
        //保存目标
        Route::post('/api/project/aim/store',
            ['as' => 'api.project.aim.store', 'uses' => 'Api\Project\AimController@projectAimStore']);
        //删除目标
        Route::post('/api/project/aim/delete/{id}',
            ['as' => 'api.project.aim.delete', 'uses' => 'Api\Project\AimController@projectAimDelete'])
            ->where('id', '[0-9]+');
        //保存目标障碍
        Route::post('/api/project/aim/hinder/store',
            ['as' => 'api.project.aim.hinder.store', 'uses' => 'Api\Project\AimController@projectAimHinderStore']);
        //审核目标障碍
        Route::post('/api/project/aim/hinder/audit',
            ['as' => 'api.project.aim.hinder.audit', 'uses' => 'Api\Project\AimController@projectAimHinderAudit']);

        //删除目标障碍
        Route::post('/api/project/aim/hinder/delete/{id}',
            ['as' => 'api.project.aim.hinder.delete', 'uses' => 'Api\Project\AimController@projectAimHinderDelete'])
            ->where('id', '[0-9]+');
    });

    //优劣势分析
    Route::group([], function () {
        //优劣势分析详情
        Route::get('/project/{project_id}/analyse/detail', ['as'   => 'project.analyse.detail',
                                                            'uses' => 'Project\AnalyseController@analyseDetail'])
            ->where('project_id', '[0-9]+');
        //优劣势分析列表
        Route::get('/project/{project_id}/analyse/common-list/{type}',
            ['as' => 'project.analyse.common-list', 'uses' => 'Project\AnalyseController@analyseCommonList'])
            ->where('project_id', '[0-9]+')->where('type', '[0-9]+');


        Route::get('/project/{project_id}/analyse/common-detail/{id}',
            ['as' => 'project.analyse.common-detail', 'uses' => 'Project\AnalyseController@analyseCommonDetail'])
            ->where('project_id', '[0-9]+')->where('id', '[0-9]+');

        Route::get('/project/{project_id}/analyse/common-edit/{type}/{id}',
            ['as' => 'project.analyse.common-edit', 'uses' => 'Project\AnalyseController@analyseCommonEdit'])
            ->where('project_id', '[0-9]+')->where('type', '[0-9]+')->where('id', '[0-9]+');

        //优劣势分析保存
        Route::post('/api/project/analyse/store',
            ['as' => 'api.project.analyse.store', 'uses' => 'Api\Project\AnalyseController@projectAnalyseStore']);
        //优劣势分析删除
        Route::post('/api/project/analyse/delete/{id}',
            ['as' => 'api.project.analyse.delete', 'uses' => 'Api\Project\AnalyseController@projectAnalyseDelete'])
            ->where('id', '[0-9]+');

    });

    //组织架构
    Route::group([], function () {
        //编辑节点
        Route::get('/project/{project_id}/structure/flow',
            ['as' => 'project.structure.flow', 'uses' => 'Project\StructureController@structure']);

        Route::get('/project/{project_id}/structure/detail/{id}',
            ['as' => 'project.structure.detail', 'uses' => 'Project\StructureController@structureDetail'])
            ->where('project_id', '[0-9]+')->where('id', '[0-9]+');

        Route::get('/project/{project_id}/structure/edit/{parent_id}/{id}',
            ['as' => 'project.structure.edit', 'uses' => 'Project\StructureController@structureEdit'])
            ->where('project_id', '[0-9]+')->where('parent_id', '[0-9]+')->where('id', '[0-9]+');

        //Api
        //保存关系图节点
        Route::post('/api/project/structure/store',
            ['as' => 'api.project.structure.store', 'uses' => 'Api\Project\StructureController@projectStructureStore']);
        //删除关系图节点
        Route::post('/api/project/structure/delete/{id}',
            ['as' => 'api.project.structure.delete', 'uses' => 'Api\Project\StructureController@projectStructureDelete']);

    });

});

//客户管理
Route::group(['middleware' => ['auth', 'role']], function () {
    //全部客户
    Route::get('/customer/list',
        ['as' => 'customer.list', 'uses' => 'Customer\CustomerController@customerList']);

    //我的客户
    Route::get('/customer/individual/list',
        ['as' => 'customer.individual.list', 'uses' => 'Customer\CustomerController@customerIndividualList']);

    //客户详情
    Route::get('/customer/detail/{id}',
        ['as' => 'customer.detail', 'uses' => 'Customer\CustomerController@customerDetail']);

    //客户创建
    Route::get('/customer/edit/{id}',
        ['as' => 'customer.edit', 'uses' => 'Customer\CustomerController@customerEdit']);
    //组织架构
    Route::get('/customer/{customer_id}/structure/flow',
        ['as' => 'customer.structure.flow', 'uses' => 'Customer\CustomerController@structure']);

    Route::get('/customer/{customer_id}/structure/detail/{id}',
        ['as' => 'customer.structure.detail', 'uses' => 'Customer\CustomerController@structureDetail']);

    Route::get('/customer/{customer_id}/structure/edit/{parent_id}/{id}',
        ['as' => 'customer.structure.edit', 'uses' => 'Customer\CustomerController@structureEdit']);

    //Api
    //保存关系图节点
    Route::post('/api/customer/structure/store',
        ['as' => 'api.customer.structure.store', 'uses' => 'Api\Customer\CustomerController@customerStructureStore']);
    //删除关系图节点
    Route::post('/api/customer/structure/delete/{id}',
        ['as' => 'api.customer.structure.delete', 'uses' => 'Api\Customer\CustomerController@customerStructureDelete']);


    //API
    //保存客户
    Route::post('/api/customer/store',
        ['as' => 'api.customer.store', 'uses' => 'Api\CustomerController@customerStore']);
    //删除客户
    Route::post('/api/customer/delete/{id}',
        ['as' => 'api.customer.delete', 'uses' => 'Api\CustomerController@customerDelete'])
        ->where('id', '[0-9]+');
    //全部客户列表
    Route::get('/api/customer/list',
        ['as' => 'api.customer.list', 'uses' => 'Api\CustomerController@customerList']);
    //我的客户列表
    Route::get('/api/customer/individual/list',
        ['as' => 'api.customer.individual.list', 'uses' => 'Api\CustomerController@customerList']);
    //客户关键字搜索
    Route::get('/api/customer/list/keyword',
        ['as' => 'api.customer.list.keyword', 'uses' => 'Api\CustomerController@getCustomerListByKeyword']);

});

//合同管理
Route::group(['middleware' => ['auth', 'role']], function () {
    //全部合同
    Route::get('/contract/list',
        ['as' => 'contract.list', 'uses' => 'Contract\ContractController@contractList']);
    //我的合同
    Route::get('/contract/individual/list',
        ['as' => 'contract.individual.list', 'uses' => 'Contract\ContractController@contractIndividualList']);
    //项目编辑
    Route::get('/contract/edit/{id}',
        ['as' => 'contract.edit', 'uses' => 'Contract\ContractController@contractEdit']);
    //项目管理详情
    Route::get('/contract/detail/{id}',
        ['as' => 'contract.detail', 'uses' => 'Contract\ContractController@contractDetail']);

    //API
    //合同保存
    Route::post('/api/contract/store',
        ['as' => 'api.contract.store', 'uses' => 'Api\Contract\ContractController@contractStore']);
    //全部合同列表
    Route::get('/api/contract/list',
        ['as' => 'api.contract.list', 'uses' => 'Api\Contract\ContractController@contractList']);
    //我的合同列表
    Route::get('/api/contract/individual/list',
        ['as' => 'api.contract.individual.list', 'uses' => 'Api\Contract\ContractController@contractIndividualList']);

    //搜索合同列表
    Route::get('/api/contract/list/keyword',
        ['as' => 'api.contract.list.keyword', 'uses' => 'Api\Contract\ContractController@getContractListByKeyword']);

    //删除我的合同
    Route::get('/api/contract/delete/{id}',
        ['as' => 'api.contract.delete', 'uses' => 'Api\Contract\ContractController@contractDelete'])
        ->where('id', '[0-9]+');

    //回款详情列表
    Route::get('/contract/{contract_id}/payment/list',
        ['as' => 'contract.payment.list', 'uses' => 'Contract\PaymentController@paymentList'])
        ->where('contract_id', '[0-9]+');

//回款计划详情
    Route::get('/contract/{contract_id}/payment/detail/{id}',
        ['as' => 'contract.payment.detail', 'uses' => 'Contract\PaymentController@paymentDetail']);

    //回款计划编辑
    Route::get('/contract/{contract_id}/payment/edit/{type}/{id}',
        ['as' => 'contract.payment.edit', 'uses' => 'Contract\PaymentController@paymentEdit']);

    //API
    //保存回款
    Route::post('/api/contract/payment/store',
        ['as' => 'api.contract.payment.store', 'uses' => 'Api\Contract\PaymentController@contractPaymentStore']);

    //删除回款
    Route::post('/api/contract/payment/delete/{id}',
        ['as' => 'api.contract.payment.delete', 'uses' => 'Api\Contract\PaymentController@contractPaymentDelete'])
        ->where('id', '[0-9]+');

    //首页内容
    //回款进度
    Route::get('/contract/payment-schedule',
        ['as' => 'contract.payment-schedule', 'uses' => 'Contract\ContractController@contractPaymentSchedule']);
    //回款列表
    Route::get('/contract/payment-schedule-list/{user_id}',
        ['as' => 'contract.payment-schedule-list', 'uses' => 'Contract\ContractController@contractPaymentScheduleList']);

    //回款详情
    Route::get('/contract/payment-schedule-detail/{user_id}',
        ['as' => 'contract.payment-schedule-detail', 'uses' => 'Contract\ContractController@contractPaymentScheduleDetail']);

    //签单进度
    Route::get('/contract/signed-progress',
        ['as' => 'contract.signed-progress', 'uses' => 'Contract\ContractController@contractSignedProgress']);
    //签单列表
    Route::get('/contract/signed-progress-list/{user_id}',
        ['as' => 'contract.signed-progress-list', 'uses' => 'Contract\ContractController@contractSignedProgressList']);
    //签单详情
    Route::get('/contract/signed-progress-detail/{user_id}',
        ['as' => 'contract.signed-progress-detail', 'uses' => 'Contract\ContractController@contractSignedProgressDetail']);

});

//产品库
Route::group([], function () {
    //公司列表
    Route::get('/product/company/list',
        ['as' => 'product.company.list', 'uses' => 'Product\ProductController@companyList']);
    //产品列表
    Route::get('/product/sorts/{company_id}/list/{type}',
        ['as' => 'product.sorts.list', 'uses' => 'Product\ProductController@sortsList']);
    //产品详情
    Route::get('/product/detail/{id}',
        ['as' => 'product.detail', 'uses' => 'Product\ProductController@Detail']);
});

//名片录入
Route::group(['middleware' => ['auth', 'role']], function () {
    //名片录入
    Route::get('/card/edit/{id}',
        ['as' => 'user.card.edit', 'uses' => 'Card\CardController@cardEdit']);

    //API
    //保存名片
    Route::post('/api/card/store',
        ['as' => 'api.card.store', 'uses' => 'Api\Card\CardController@storeCard']);
    Route::post('/api/card/delete/{id}',
        ['as' => 'api.card.delete', 'uses' => 'Api\Card\CardController@deleteCard']);

    //名片夹联想
    Route::get('/api/card/list/keyword',
        ['as' => 'api.card.list.keyword', 'uses' => 'Api\Card\CardController@getCardsByKeyword']);

});

//帮助中心
Route::group(['middleware' => 'auth'], function () {
    //全部合同
    Route::get('/help/list', ['as' => 'help.list', 'uses' => 'Help\HelpController@helpList']);
    //销售线索详情
    Route::get('/help/sales/detail/{id}', ['as' => 'help.sales.detail', 'uses' => 'Help\HelpController@helpSalesDetail']);
    //客户管理详情
    Route::get('/help/customer/detail/{id}', ['as' => 'help.customer.detail', 'uses' => 'Help\HelpController@helpCustomerDetail']);
    //合同管理详情
    Route::get('/help/contract/detail/{id}', ['as' => 'help.contract.detail', 'uses' => 'Help\HelpController@helpContractDetail']);
    //项目管理详情
    Route::get('/help/project/detail/{id}', ['as' => 'help.project.detail', 'uses' => 'Help\HelpController@helpProjectDetail']);
    //我
    Route::get('/help/user/detail/{id}', ['as' => 'help.user.detail', 'uses' => 'Help\HelpController@helpUserDetail']);
});


//个人中心
Route::group(['middleware' => 'auth'], function () {
    //list
    Route::get('/user/list',
        ['as' => 'user.list', 'uses' => 'User\UserController@userList']);

    //个人信息
    Route::get('/user/info',
        ['as' => 'user.info', 'uses' => 'User\UserController@userInfo']);

    //通讯录
    Route::get('/user/contacts',
        ['as' => 'user.contacts', 'uses' => 'User\UserController@userContacts']);
    //通讯录个人详情
    Route::get('/user/contacts/{id}',
        ['as' => 'user.contacts.detail', 'uses' => 'User\UserController@userContactsDetail'])
        ->where('id', '[0-9]+');

    //我的审批
    Route::get('/user/approval/list',
        ['as' => 'user.approval.list', 'uses' => 'User\UserController@userApprovalList']);

    //消索消索详情页
    Route::get('/user/approval/sale/detail/{id}',
        ['as' => 'user.approval.sale.detail', 'uses' => 'User\UserController@userApprovalSaleDetail']);

    //审批页面
    Route::get('/user/approval/hinder/detail/{id}',
        ['as' => 'user.approval.hinder.detail', 'uses' => 'User\UserController@userApprovalHinderDetail']);

    Route::get('/user/approval/hinder/detail/{aim_id}/aim',
        ['as' => 'user.approval.hinder.detail.aim', 'uses' => 'User\UserController@userApprovalDetailAim'])
        ->where('aim_id', '[0-9]+');

    //任务列表
    Route::get('/user/sign-task/list/{user_id}', ['as' => 'user.sign-task.list', 'uses' => 'User\UserController@userSignTaskList']);
    //任务详情
    Route::get('/user/sign-task/detail/{id}', ['as' => 'user.sign-task.detail', 'uses' => 'User\UserController@userSignTaskDetail']);
    //创建任务
    Route::get('/user/sign-task/edit/{id}', ['as' => 'user.sign-task.edit', 'uses' => 'User\UserController@userSignTaskEdit']);

    //意见反馈
    Route::get('/user/opinion',
        ['as' => 'user.opinion', 'uses' => 'User\UserController@userOpinion']);
    //设置
    Route::get('/user/set',
        ['as' => 'user.set', 'uses' => 'User\UserController@userSet']);

    //API
    //修改密码
    Route::post('/api/user/modify-password',
        ['as' => 'api.user.modify.password', 'uses' => 'Api\User\UserController@modifyPassword']);

    //保存意见反馈
    Route::post('/api/user/feedback/store',
        ['as' => 'api.user.feedback.store', 'uses' => 'Api\User\UserController@storeUserFeedback']
    );

    //目标障碍审核 列表API
    Route::get('/api/user/approval/hinder/list',
        ['as' => 'api.user.approval.hinder.list', 'uses' => 'Api\User\UserController@approvalHinders']);

    //销售线索审核 列表API
    Route::get('/api/user/approval/sale/list',
        ['as' => 'api.user.approval.sale.list', 'uses' => 'Api\User\UserController@approvalSales']);

    //保存签约任务
    Route::post('/api/user/sign-task/store',
        ['as' => 'api.user.sign-task.store', 'uses' => 'Api\User\UserController@storeSignTask']);

    //名片录入 需要角色权限
    Route::group(['middleware' => ['role']], function () {
        //名片夹
        Route::get('/user/card/list',
            ['as' => 'user.card.list', 'uses' => 'User\UserController@userCardList']);

        //名片想起
        Route::get('/user/card/detail/{id}',
            ['as' => 'user.card.detail', 'uses' => 'User\UserController@userCardDetail'])
            ->where('id', '[0-9]+');


        //我的审批-销售线索
        Route::get('/user/approval/sale/list',
            ['as' => 'user.approval.sale.list', 'uses' => 'User\UserController@userApprovalSaleList']);


        //我的审批-障碍输出
        Route::get('/user/approval/hinder/list',
            ['as' => 'user.approval.hinder.list', 'uses' => 'User\UserController@userApprovalHinderList']);

        //任务分配
        Route::get('/user/sign-task/distribution',
            ['as' => 'user.sign-task.distribution', 'uses' => 'User\UserController@userSignTaskDistribution']);

    });
});


