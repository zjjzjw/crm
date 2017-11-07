$(function() {
    var messageDialog = require('./../../../component/AUI/alert'),
        FormUtils = require('./../../../component/formUtils'),
        addLog = require('./../../partials/addLog'),
        CallUp = require('./../../partials/callUp'),
        EidtDialog = require('./../modules/visitTaskDialog'),
        services = require('./../../services/customerVisitServices');

    var list = $.params.list,
        eidtDialog = null,
        callUp = CallUp();

    function init() {
        initFilter();

        $('#visit_list').on('click', '.button', function() {
            var $target = $(this),
                index = $target.closest('li').data('index'),
                type = $target.data('type');

            dispatchHandle(type, list[+index]);
        }).on('click', '.call-up', function() {
            var $target = $(this),
                index = $target.closest('li').data('index'),
                msg = list[+index];

            callUp.makeCall(msg.backup_phone ? [msg.buyer_phone, msg.backup_phone] : [msg.buyer_phone], addCallFeedbaclLog.bind(null, {id: msg.id}));
        });
    }

    function dispatchHandle(type, msg) {
        switch (type) {
            case 'cancel':
                messageDialog.confirm(getCancelMessage(msg), cancelVisit.bind(null, msg));
                break;
            case 'edit':
                openEidtDialog(msg);
                break;
            case 'accompany':
                addLog({
                    title: '记录陪看',
                    params: {'id': msg.id},
                    resources: services.putAccompany
                });
                break;
            case 'feedback':
                addLog({
                    title: '记录回访',
                    params: {'id': msg.id},
                    resources: services.putFeeback
                });
                break;
            default:
                break;
        }
    }

    function getCancelMessage(msg) {
        /* jshint camelcase: false */
        var message = '<p>你确定取消“' + msg.visit_time + '”' + msg.buyer_name +
                    '的带看？</p><p class="text-light">注：确定后将会发送信息给全部带看楼盘的项目经理</p>';

        return message;
    }

    function openEidtDialog(msg) {
        if (!eidtDialog) {
            eidtDialog = new EidtDialog({'title': '修改带看'});

            eidtDialog.on('visit_confoirm', function(data, dialog, $error) {
                if (data.id) {
                    editVisit(data);
                    dialog.close();
                    $error.hide();
                } else {
                    $error.text('请选择需要修改的带看');
                }
            });
        }

        eidtDialog.open(msg);
    }

    function addCallFeedbaclLog(params, callRes) {
        addLog({
            title: '电话记录',
            params: $.extend(params, callRes),
            resources: services.putCallFeeback
        });
    }

    function initFilter() {
        var formUtils = new FormUtils({wrap: '#filer_wrapper'});

        formUtils.$wrap.on('change', 'select', function() {
            var name = $(this).attr('name');

            if (name == 'center_id') {
                formUtils.getUnitByName('team_id', 'select').val('');
                formUtils.getUnitByName('broker_id', 'select').val('');
            } else if (name == 'team_id') {
                formUtils.getUnitByName('broker_id', 'select').val('');
            }

            formUtils.getUnitByName('keyword').val('');
            formUtils.$wrap.submit();
        });
    }

    function cancelVisit(msg, data) {
        if (data.status) {
            services.manageVisit({
                data: {'id': msg.id},
                type: 'cancel',
                success: function() {
                    location.reload(true);
                },
                error: function(res) {
                    messageDialog.error(res.msg);
                }
            });
        }
    }

    function editVisit(data) {
        services.manageVisit({
            data: data,
            type: 'update',
            success: function() {
                location.reload(true);
            },
            error: function(res) {
                messageDialog.error(res.msg);
            }
        });
    }

    init();
});