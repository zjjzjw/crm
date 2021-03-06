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

        $(document).on('click', '.add-parameter-btn', function () {
            var html = temp('parameter_tpl', {});
            $('.add-parameter').append(html);
        });

        $(document).on('click', '.del-parameter-btn', function () {
            $(this).parents('li').remove();
        });

        fileupload({
            acceptFileTypes: ['csv', 'vnd.ms-excel','text'],
            dom: $('#addPicture-sales'),
            callback: function (result, data) {
                //这个时候是资源，应该显示默认图片
                result.url = '/www/image/excel.png';
                result.origin_url = '/www/image/excel.png';
                var tempFiles = temp('files_tpl', {
                    data: data,
                    result: result,
                    name: 'sales',
                    single: true
                });

                $('.add-sales').before(tempFiles);
                $('.add-sales').css('border-color', '#d9d9d9');

                $('.add-sales').hide();

                //图片删除
                $('.picture-box-sales .show-item').on('click', '.delete', function () {
                    $(this).parent('.show-item').remove();
                    $('.add-sales').show();
                });
            }
        });

        //删除
        $('.picture-box-sales .show-item').on('click', '.delete', function () {
            $(this).parent('.show-item').remove();
            $('.add-sales').show();
        });

    };

    new Edit();
});