require([
    'jquery',
    'lib/temp',
    'page.params',
    'component/upload',
    'jquery.fileupload',
    'jquery.form.validator',
    'component/ajax',
    'jquery.datetimepicker'
], function ($, temp, params, fileupload) {

    var Edit = function () {
        var self = this;
        self.init();
    };


    Edit.prototype.init = function () {
        var self = this;

        $('.date').datetimepicker({
            timepicker: false,
            format: 'Y-m-d',
            formatDate: 'Y-m-d',
            closeOnDateSelect: true,
            scrollInput: false,
            lang: 'zh'
        });

        $.validate({
            form: '#form',
            onSuccess: function ($form) {
                return true;
            }
        });

        fileupload({
            acceptFileTypes: ['jpg', 'jpeg', 'png', 'bmp'],
            dom: $('#addPicture-user_images'),
            callback: function (result, data) {
                var tempFiles = temp('files_tpl', {
                    data: data,
                    result: result,
                    name: 'user_images',
                    single: true
                });

                $('.add-user_images').before(tempFiles);
                $('.add-user_images').css('border-color', '#d9d9d9');

                $('.add-user_images').hide();

                //图片删除
                $('.picture-box-user_images .show-item').on('click', '.delete', function () {
                    $(this).parent('.show-item').remove();
                    $('.add-user_images').show();
                });
            }
        });

        //删除
        $('.picture-box-user_images .show-item').on('click', '.delete', function () {
            $(this).parent('.show-item').remove();
            $('.add-user_images').show();
        });

    };

    new Edit();


});