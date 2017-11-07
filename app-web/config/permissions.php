<?php

return [

    //查看-销售线索
    'sale.list'                        => '10001',//√
    'sale.individual.list'             => '10001',//√
    'sale.detail'                      => '10001',//√
    'api.sale.list'                    => '10001',
    'api.sale.list.keyword'            => '10001',
    'api.sale.individual.list'         => '10001',

    //添加销售线索 √
    'sale.add'                         => '10002',
    'sale.view.edit'                   => '10003', //销售线索编辑

    //修改销售线索 √
    'sale.edit'                        => ['10002', '10003'],
    'api.sale.store'                   => ['10002', '10003'],
    'api.sale.delete'                  => '10003', //销售线索删除


    //认领销售线索 //??
    'sale.claim'                       => '10004',
    'api.sale.claim'                   => '10004',

    //分配销售线索
    'sale.distribution'                => '10005',//√
    'api.sale.assign.user'             => '10005',//√

    //查看项目基本信息
    'project.list'                     => '10006',//√
    'project.detail'                   => '10006',//√
    'api.project.list'                 => '10006',
    'project.individual.list'          => '10006',//√
    'project.partner.list'             => '10006',//√
    'api.project.individual.list'      => '10006',
    'api.project.list.keyword'         => '10006',

    //首页入口
    //任务清单
    'project.task-manifest'            => '10006',
    'project.task-manifest-list'       => '10006',
    'project.task-manifest-detail'     => '10006',

    //添加项目基本信息
    'project.add'                      => '10007',//√
    'project.view.edit'                => '10008',

    //编辑项目基本信息
    'project.edit'                     => ['10007', '10008'],//√
    'api.project.store'                => ['10007', '10008'],//√
    'api.project.delete'               => '10008',//√

    //查看项目档案
    'project.file'                     => '10009',
    'project.file.list'                => '10009',//??
    'project.file.detail'              => '10009',//√


    //添加项目详情
    'project.file.add'                 => '10010',//??
    'project.file.view.edit'           => '10011',//编辑项目档案

    //编辑项目详情
    'project.file.edit'                => ['10010', '10011'],//√
    'api.project.file.store'           => ['10010', '10011'],//√
    'api.project.file.delete'          => '10011',//√

    //查看组织架构图
    'project.structure.list'           => '10012',//??
    'project.structure.flow'           => '10012',//√
    'project.structure.detail'         => '10012',//√

    //添加组织架构图
    'project.structure.add'            => '10013',
    'project.structure.view.edit'      => '10014', //项目组织架构编辑

    //编辑组织架构图
    'project.structure.edit'           => ['10013', '10014'],//√
    'api.project.structure.store'      => ['10013', '10014'],//√
    'api.project.structure.delete'     => '10014',//√


    //查看优劣势分析
    'project.analyse.list'             => '10015',//??
    'project.analyse.detail'           => '10015',//√
    //我与客户关系列表
    'project.analyse.common-list'      => '10015',//√
    'project.analyse.common-detail'    => '10015',//√


    //添加优劣势分析
    'project.analyse.add'              => '10016',//√
    'project.analyse.view.edit'        => '10017',//优劣势分析编辑权限

    //编辑优劣势分析
    'project.analyse.edit'             => ['10016', '10017'],//√
    'project.analyse.common-edit'      => ['10016', '10017'],//√
    'api.project.analyse.store'        => ['10016', '10017'],//√
    'api.project.analyse.delete'       => '10017',//√


    //查看采购流程
    'project.purchase.list'            => '10018',//√
    'project.purchase.detail'          => '10018',//√


    //添加采购流程
    'project.purchase.add'             => '10019',//√
    'project.purchase.view.edit'       => '10020',//采购流程编辑权限

    //编辑采购流程
    'project.purchase.edit'            => ['10019', '10020'],//√
    'api.project.purchase.store'       => ['10019', '10020'],//√
    'api.project.purchase.delete'      => '10020',//√


    //查看目标设置
    'project.aim.list'                 => '10021',//√
    'project.aim.detail'               => '10021',//√
    'project.aim.main'                 => '10021',//√
    'project.aim.progress'             => '10021',//√

    //销售线索审核
    'user.approval.sale.list'          => '10036',
    'api.sale.audit'                   => '10036',

    //添加目标设置
    'project.aim.add'                  => '10022',//√
    'project.aim.view.edit'            => '10023',//目标权限设置

    //编辑目标设置
    'project.aim.edit'                 => ['10022', '10023'],//√
    'api.project.aim.store'            => ['10022', '10023'],//√
    'api.project.aim.delete'           => '10023',//目标详情删除

    //查看目标障碍
    'project.aim.hinder.list'          => '10024',//√
    'project.aim.hinder.detail'        => '10024',//√

    //添加目标障碍
    'project.aim.hinder.add'           => '10025',//√目标障碍添加
    'project.aim.hinder.view.edit'     => '10026',

    //编辑目标障碍
    'project.aim.hinder.edit'          => ['10025', '10026'],//√目标障碍添加编辑
    'api.project.aim.hinder.store'     => ['10025', '10026'],//√目标障碍添加编辑
    'api.project.aim.hinder.delete'    => '10026', //目标障碍删除


    //目标障碍审核
    'user.approval.hinder.list'        => '10037',
    'api.project.aim.hinder.audit'     => '10037',


    //查看客户信息
    'customer.list'                    => '10027',//√
    'customer.detail'                  => '10027',//√
    'api.customer.list'                => '10027',
    'customer.individual.list'         => '10027',
    'api.customer.individual.list'     => '10027',
    'customer.structure.flow'          => '10027', //客户组织架构图
    'customer.structure.detail'        => '10027', //客户组织架构图详情
    'api.customer.list.keyword'        => '10027',

    //添加客户信息
    'customer.add'                     => '10028',//??
    'customer.view.edit'               => '10029',//客户编辑权限

    //编辑客户信息
    'customer.edit'                    => ['10028', '10029'],//√
    'api.customer.store'               => ['10028', '10029'],//√
    'customer.structure.edit'          => '10029',
    'api.customer.delete'              => '10029',

    //查看合同信息
    'contract.list'                    => '10030', //合同列表√
    'contract.detail'                  => '10030', //合同详情√
    'contract.payment.list'            => '10030', //合同回款列表√
    'api.contract.list'                => '10030', //合同列表API
    'contract.payment.detail'          => '10030', //合同付款详情√
    'contract.individual.list'         => '10030', //我的合同列表
    'api.contract.individual.list'     => '10030', //我的合同API
    'api.contract.list.keyword'        => '10030', //合同列表搜索


    //回款进度
    'contract.payment-schedule'        => '10030',
    'contract.payment-schedule-list'   => '10030',
    'contract.payment-schedule-detail' => '10030',

    //签单进度
    'contract.signed-progress'         => '10030',
    'contract.signed-progress-list'    => '10030',
    'contract.signed-progress-detail'  => '10030',

    //添加合同信息
    'contract.add'                     => '10031',//√
    'contract.view.edit'               => '10032',


    //编辑合同信息
    'contract.edit'                    => ['10031', '10032'],//√
    'api.contract.store'               => ['10031', '10032'],//√保存合同
    'contract.payment.edit'            => '10032',//√按钮还在页面有权限
    'api.contract.delete'              => '10032',//删除合同
    'api.contract.payment.store'       => '10032',//添加回款计划
    'api.contract.payment.delete'      => '10032',//删除回款计划

    //参看名片
    'card.list'                        => '10033',//??
    'user.card.list'                   => '10033',
    'card.detail'                      => '10033',
    'user.card.detail'                 => '10033',
    'api.card.list.keyword'            => '10033',

    //添加名片
    'card.add'                         => '10034',//??
    'user.card.add'                    => '10034',//√
    'user.card.view.edit'              => '10035',

    //修改名片 具有添加的也可以保存
    'card.edit'                        => ['10034', '10035'],//??
    'user.card.edit'                   => ['10034', '10035'],//√
    'api.card.store'                   => ['10034', '10035'],//√
    'api.card.delete'                  => '10035',

    //合同-任务分配
    'user.sign-task.distribution'      => '10038',

];
