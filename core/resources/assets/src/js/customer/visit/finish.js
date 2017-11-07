$(function() {
    var messageDialog = require('./../../../component/AUI/alert'),
        fileupload = require('./../../../component/AUI/fileupload'),
        services = require('./../../services/customerVisitServices');

    function view() {
        var $form = $('#complete_visit'),
            $addAnchor = $('#add-anchor');

        renderImage($addAnchor, $.params.visitImages || {});
        initFileupload($addAnchor);
        bindEvent($form);
    }

    function bindEvent($form) {
        $form
            .on('click', '.del', function() {
                $(this).closest('.uploadify-item').remove();
            })
            .on('submit', function() {
                var data = confirmData(analysisParam($form.serializeArray()));

                if (typeof data === 'string') {
                    messageDialog.error(data);
                } else {
                    completeVisit(data);
                }

                return false;
            });
    }

    function initFileupload($addAnchor) {
        fileupload({
            dom: $('#uploadify'),
            acceptFileTypes: ['gif', 'jpg', 'jpeg', 'png'],
            data: {
                'bucket': $.params.bucket
            },
            callback: function (result) {
                if (result && result.id) {
                    var data = {};
                    data[result.id] = result.url;
                    renderImage($addAnchor, data);
                }
            }
        });
    }

    function renderImage($addAnchor, data) {
        $addAnchor.before($.temp('uploadify_tpl', {'data': data}));
    }

    function analysisParam(list) {
        var params = {};

        $.each(list, function(i, item) {
            var key = item.name,
                val = $.trim(item.value);

            if (val) {
                if (~key.indexOf('[]')) {
                    key = key.split('[]')[0];

                    !params[key] && (params[key] = []); // jshint ignore:line

                    params[key].push(val);
                } else {
                    params[key] = val;
                }
            }
        });

        return params;
    }

    function confirmData(data) {
        /* jshint camelcase: false */
        if (!data.visit_feedback) {
            return '请填写带看反馈';
        }

        if (!data.visit_image_ids) {
            return '请上传带看单';
        }

        return data;
    }

    function completeVisit(data) {
        services.completeVisit({
            data: data,
            success: function() {
                location.reload(true);
            },
            error: function(res) {
                messageDialog.error(res.msg);
            }
        });
    }

    view();
});
