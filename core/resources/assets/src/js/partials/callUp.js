module.exports = (function($) {
    var Dialog = require('./../../component/AUI/dialog'),
        messageDialog = require('./../../component/AUI/alert'),
        services = require('./../services/commonServices');

    var CallUp = function(options) {
        if (!(this instanceof CallUp)) {
            return new CallUp(options);
        }

        var defOpts = {
                id: 'select_phone',
                title: '拨打电话',
                btnGroupTpl: '',
                contentTpl: '',
                resources: services.callUp,
                params: {},
                success: null,
                error: ajaxError
            };

        this.opts = $.extend({}, defOpts, options)
    }

    CallUp.prototype = {
        constructor: CallUp,

        makeCall: function(phone, params, cb) {
            if (typeof params === 'function') {
                this.successCb = params;
                this.params = null;
            } else {
                this.params = params;
                this.successCb = cb;
            }

            if ($.isArray(phone)) {
                if (phone.length > 1) {
                    this._openDialog(phone);
                } else {
                    this._makeCall(phone[0]);
                }
            } else {
                this._makeCall(phone);
            }
        },

        _openDialog: function(phone) {
            if (!this.callUpDialog) {
                var self = this,
                    opts = self.opts,
                    callUpDialog = new Dialog({
                        id: opts.id,
                        title: opts.title,
                        btnGroupTpl: opts.btnGroupTpl,
                        contentTpl: opts.contentTpl
                    });

                callUpDialog.$body
                    .addClass('select-phone')
                    .on('click', '.phone', function() {
                        self._makeCall($(this).data('phone'));
                        callUpDialog.close();
                    });

                self.callUpDialog = callUpDialog;
            }

            this.callUpDialog.open(tempSelectOptions(phone));
        },

        _makeCall: function(phone) {
            var self = this,
                opts = self.opts,
                resources = opts.resources,
                params = self.params || opts.params,
                successCb = self.successCb || opts.success,
                errorCb = opts.error;

            if (typeof resources === 'string') {
                $.ajax({
                    type: 'GET',
                    url: resources,
                    data: $.extend({'phone': phone}, params),
                    dataType: 'json',
                    success: function(res) {
                        successCb && successCb(res)
                    },
                    error: function(res) {
                        errorCb(res);
                    }
                });
            } else if (typeof resources === 'function') {
                try {
                    resources({
                        data: $.extend({'phone': phone}, params),
                        success: function(res) {
                            successCb && successCb(res)
                        },
                        error: function(res) {
                            errorCb(res);
                        }
                    });
                } catch (err) {}
            }
        }
    };

    function ajaxError(res) {
        messageDialog.error(res.msg);
    }

    function tempSelectOptions(phone) {
        var tpl = '';

        $.each(phone, function(i, item) {
            tpl += '<p>' + item + '<span class="phone" data-phone="' + item + '"><i class="iconfont"></i>拨打</span></p>';
        });

        return tpl;
    }

    return CallUp;
}(jQuery))