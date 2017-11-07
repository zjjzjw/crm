$(function() {
    var albumPop = require('../partials/albumPop.js'), // jshint ignore:line
        messageDialog = require('./../../component/AUI/alert'),
        commonServices = require('./../services/commonServices');

    function View() {
        bindEvent();
    }

    function bindEvent() {
        $('#call_up').click(function() {
            var $target = $(this);

            callUp({
                'phone': $target.data('phone')
            });
        });
    }

    function callUp(req) {
        commonServices.callUp({
            data: req,
            success: function() {
                messageDialog.error('请求拨打成功，请耐心等待');
            },
            error: function(res) {
                messageDialog.error(res.msg);
            }
        });
    }

    View();
});