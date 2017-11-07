$(function () {
    require('./../../partials/customerMessage');
    var messageDialog = require('./../../../component/AUI/alert'),
        commonServices = require('./../../services/commonServices'),
        services = require('./../../services/customerServices');

    function init() {
        $('.name').attr('data-validation', '');
        $('.gender').attr('data-validation', '');
    }

    function bindEvent() {
        $('.call-result').change(function () {

            if ($(this).val() == 5) {
                $('#customer_message').show();
                $('#log_message').hide();
                $('.name').attr('data-validation', 'required');
                $('.gender').attr('data-validation', 'required');
            } else if ($(this).val() == 4 || $(this).val() == 7) {
                $('#customer_message').hide();
                $('#log_message').show();
                $('.name').attr('data-validation', '');
                $('.gender').attr('data-validation', '');
            } else {
                $('#customer_message').hide();
                $('#log_message').hide();
                $('.name').attr('data-validation', '');
                $('.gender').attr('data-validation', '');
            }
        });

        $('.call').click(function () {
            callUp($(this).data('phone'));
        });
    }

    function callUp(phone) {
        commonServices.callUp({
            data: {'phone': phone},
            success: function (res) {
                putCallLogId(res.call_log_id);
                $('#call_log_id').val(res.call_log_id);
                messageDialog.error('拨打成功请耐心等待，不要刷新页面！');
            },
            error: function (res) {
                messageDialog.error(res.msg);
            }
        });
    }

    function putCallLogId(callLogId) {
        services.putCallLogId({
            data: {
                'customer_id': $('#customer_id').val(),
                'call_log_id': callLogId
            }
        });
    }

    init();
    bindEvent();
});
