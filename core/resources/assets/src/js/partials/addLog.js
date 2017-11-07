module.exports = (function($) {
    var Dialog = require('./../../component/AUI/dialog'),
        tpl = '<div class="row collapse">' +
                '<div class="columns small-2"><label class="text-center middle">记录内容：</label></div>' +
                '<div class="columns small-10"><div class="form-group"><textarea rows="4"></textarea></div></div>' +
            '</div>' +
            '<div class="row collapse">' +
                '<div class="columns small-2"></div>' +
                '<div class="columns small-10"><p class="error text-alert hidden"></p></div>' +
            '</div>';

    var addLogDialog = null,
        defOpts = {
            title: '记录',
            params: {},
            resources: null,
            success: ajaxSuccess,
            error: ajaxError,
            noContent: '请填写记录内容'
        };

    var addLog = function(options) {
            var opts = $.extend({}, defOpts, options);

            _openAddDialog(opts);
        }

    function _openAddDialog(opts) {
        if (!addLogDialog) {
            _initAddDialog();
        }

        addLogDialog.logOpts = opts;
        addLogDialog.setTitle(opts.title);
        addLogDialog.open(opts.label);
    }

    function _initAddDialog() {
        addLogDialog = new Dialog({
            'id': 'add_log_dialog',
            'contentTpl': tpl,
        });

        var $content = addLogDialog.$body.find('textarea'),
            $error = addLogDialog.$body.find('.error');

        addLogDialog.on('dialog_opened', function() {
            $content.val('');
            $error.hide();
        });

        addLogDialog.on('dialog_closed', function($dom) {
            if ($dom && $dom.data('status')) {
                var content = $.trim($content.val()),
                    opts = this.logOpts;

                if (content) {
                    if (opts.resources) {
                        opts.resources({
                            data: $.extend({'content': content}, opts.params),
                            success: opts.success.bind(null, this),
                            error: opts.error.bind(null, $error)
                        });
                    } else {
                        opts.success(this, $.extend({'content': content}, opts.params));
                    }
                } else {
                    opts.error.apply(null, [$error, {msg: opts.noContent}]);
                }
            } else {
                this.opts = null;
                this.close();
            }
        });
    }

    function ajaxSuccess() {
        location.reload(true);
    }

    function ajaxError($error, res) {
        $error.text(res.msg).show();
    }

    return addLog;
}(jQuery))