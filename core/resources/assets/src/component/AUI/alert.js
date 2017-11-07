;(function(){
    var moduleName = (function($, common) {
        var Dialog = require('./dialog');
        var popDialog = new Dialog({
            id: 'alert_dialog'
        });
        var Alert = {};

        Alert.confirm = function(someWord, callback) {
            popDialog.setTitle('提示');
            popDialog.setButtonGroup('<button class="hollow button small" data-status="0">取消</button><button class="button small" data-status="1">确定</button>');
            popDialog.$body.html('<div class="alert-confirm text-center h5">' + someWord + '</div>');
            popDialog.open();
            popDialog.on('dialog_closed',function(e) {
                callback && callback({
                    e: e,
                    status: e.attr('data-status') != '0'
                });
                popDialog.off('dialog_closed');
                popDialog.close();
            });
        }

        Alert.error = function(someWord, callback) {
            popDialog.setTitle('提示');
            popDialog.setButtonGroup('<button class="button small">确定</button>');
            popDialog.$body.html('<div class="alert-error text-center text-alert h5">' + someWord + '</div>');
            popDialog.open();
            popDialog.on('dialog_closed',function(e) {
                callback && callback({
                    e: e,
                    status: e.attr('data-status') != '0'
                });
                popDialog.off('dialog_closed');
                popDialog.close();
            });
        }

        return Alert;

    })(jQuery, AGJ.common);
    
    if (typeof module !== 'undefined' && typeof exports === 'object') {
        module.exports = moduleName;
    } else if (typeof define === 'function' && (define.amd || define.cmd)) {
        define(function() { return moduleName; });
    } else {
        this.moduleName = moduleName;
    }
}).call(function() {
    return this || (typeof window !== 'undefined' ? window : global);
});