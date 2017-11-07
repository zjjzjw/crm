$(function() {
    var Dialog = require('./../../component/AUI/dialog'),
        messageDialog = require('./../../component/AUI/alert'),
        CallUp = require('./../partials/callUp'),
        VisitDialog = require('./modules/visitTaskDialog'),
        services = require('./../services/customerServices'),
        visitServices = require('./../services/customerVisitServices');

    var customerId = $.params.id,
        visitDialog = null,
        callUp = null,
        followupDialog = null,
        FOLLOWUP_WORDS = 1,
        FOLLOWUP_RECORD = 2;

    function view() {
        callUp = CallUp({
            success: openFollowupDialog
        });
        bindEvent();
    }

    function bindEvent() {
        var $followupForm = $('#followup'),
            $followup = $followupForm.find('textarea');

        $('#handle').on('click', '.button', function() {
            var type = $(this).data('type');

            if (type) {
                if (type == 'tel') {
                    callUp.makeCall($.params.backupPhone ? [$.params.phone, $.params.backupPhone] : [$.params.phone]);
                } else {
                    openVisitDialog();
                }
            }
        });

        $followupForm.on('submit', function() {
            var followup = $.trim($followup.val());

            if (followup) {
                messageDialog.confirm('确定提交此次跟进？', createFollowup.bind(null, {'type': FOLLOWUP_WORDS, 'content': followup}));
            }

            return false;
        });
    }

    function openVisitDialog() {
        if (!visitDialog) {
            visitDialog = new VisitDialog({'title': '预约带看'});

            visitDialog.on('visit_confoirm', function(data, dialog, $error) {
                createVisit($.extend({'buyer_id': customerId}, data));
                dialog.close();
                $error.hide();
            });
        }

        visitDialog.open();
    }

    function openFollowupDialog(data) {
        if (!followupDialog) {
            var $followup, $error;

            followupDialog = new Dialog({
                'id': 'followup_dialog',
                'title': '电话记录',
                'contentTpl': $('#followup_dialog_tpl').html(),
                'btnGroupTpl': '<button class="button small" data-status="1">提交</button>'
            });
            followupDialog.dom.parent().off('click.zf.reveal');
            $followup = followupDialog.$body.find('textarea');
            $error = followupDialog.$body.find('.error');

            followupDialog.on('dialog_closed', function($dom) {
                if ($dom && $dom.data('status')) {
                    var followup = $.trim($followup.val());

                    if (followup) {
                        if (this.params) {
                            createFollowup($.extend({'type': FOLLOWUP_RECORD, 'content': followup}, this.params));
                            this.close();
                        } else {
                            $error.text('当前无关联电话记录，请拨打电话再填写电话跟进').show();
                        }
                    } else {
                        $error.text('请填写跟进内容').show();
                    }
                } else {
                    this.params = null;
                    $followup.val('');
                    $error.hide();
                }
            });
        }

        followupDialog.params = data;
        followupDialog.open();
    }

    function createVisit(req) {
        visitServices.manageVisit({
            data: req,
            type: 'add',
            success: function() {
                location.reload(true);
            },
            error: function(res) {
                messageDialog.error(res.msg);
            }
        });
    }

    function createFollowup(req, data) {
        if (!data || data.status) {
            services.followup({
                data: req,
                id: customerId,
                success: function() {
                    location.reload(true);
                },
                error: function(res) {
                    messageDialog.error(res.msg);
                }
            });
        }
    }

    view();
});