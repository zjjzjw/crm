require([
    'jquery',
    'lib/temp',
    'component/area',
    'page.params',
    'component/upload',
    'jquery.fileupload',
    'jquery.form.validator',
    'component/ajax'
], function ($, temp, Area, params, fileupload) {
    var Edit = function () {
        var self = this;
        self.init();
    };

    Edit.prototype.init = function () {
        var self = this;
        $.validate({
            form: '#form',
            onSuccess: function ($form) {
                if ($('.show-item').length > 0 && $('.show-item').length < 4) {
                    $('#addPicture-product_images').parent().remove('.form-error');
                    return true;
                }
                if (!$('#addPicture-product_images').parent().find('.form-error').length) {
                    $('#addPicture-product_images').parent().append('<span class="help-block form-error">图片个数1-3张</span>');
                    return false;
                }
                return false;
            }
        });

        $(document).on('click', '.add-parameter-btn', function () {
            var html = temp('parameter_tpl', {});
            $('.add-parameter').append(html);
        });

        $(document).on('click', '.del-parameter-btn', function () {
            $(this).parents('li').remove();
        });

        //选择分类
        var area = new Area({'idNames': ['ascription', 'ascription_id'], 'data': params.area});
        area.selectedId(params.ascription, params.ascription_id);


        fileupload({
            acceptFileTypes: ['plain'],
            dom: $('#addPicture-product_images'),
            callback: function (result, data) {
                var tempFiles = temp('files_tpl', {
                    data: data,
                    result: result,
                    name: 'product_images',
                    single: false
                });

                $('.add-product_images').before(tempFiles);
                $('.add-product_images').css('border-color', '#d9d9d9');


                //图片删除
                $('.picture-box-product_images .show-item').on('click', '.delete', function () {
                    $(this).parent('.show-item').remove();
                    $('.add-product_images').show();
                });
            }
        });

        //删除
        $('.picture-box-product_images .show-item').on('click', '.delete', function () {
            $(this).parent('.show-item').remove();
            $('.add-product_images').show();
        });
    };

    new Edit();
});