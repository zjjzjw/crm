require([
    'jquery',
    'lib/temp',
    'page.params',
    'lib/popup',
    'app/service/depart/departService',
    'component/upload',
    'jquery.fileupload',
    'jquery.form.validator',
    'jquery.datetimepicker',
], function ($, temp, params, Popup, service, fileupload) {
    var Edit = function () {
        $departBoxPop = new Popup({
            width: 800,
            height: 600,
            contentBg: '#fff',
            maskColor: '#000',
            maskOpacity: '0.6',
            content: $('#departBoxTpl').html()
        });
        var self = this;
        self.init();
    };


    Edit.prototype.init = function () {
        var self = this;
        $(document).on('click','.depart',function(){
            $departBoxPop.showPop();
        });
        $(document).on('click','.save',function(){
            var chooseVal = $('input[name="departName"]').val();
            var chooseId = $('input[name="departId"]').val();
            if(chooseVal == ''){
                $('.choose-error').show();
            }else {
                $('.depart').html(chooseVal);
                $('input[name="depart_ids[]"]').val(chooseId);
                $departBoxPop.closePop();
            }
        });
        $(document).on('click','.close',function(){
            $departBoxPop.closePop();
            $('.choose-error').hide();
        });
        //显示下层
        $(document).on('click','.to-all',function(){
            $(this).parent().parent().addClass('focus-item');
            $(this).addClass('close-all').removeClass('to-all').html('—');
            var id= $(this).data('id');
            var parent_id = $(this).data('parentid');
            var user_id = $('input[name="id"]').val();
            if($(this).parent().parent().hasClass('first-request')){
                $(this).parent().next().show();
                $('.focus-item').removeClass('focus-item');
                console.log('请求过了');
            }else{
                //请求api
                console.log('请求API');
                $(this).parent().parent().addClass('first-request');
                service.depart({
                    data: {
                        id: id,
                        parent_id: parent_id,
                        user_id: user_id
                    },
                    sucFn: function (data, status, xhr) {
                        var html = temp('node_tpl', {result:data});
                        $('.focus-item').append(html);
                        $('.focus-item').find('ul').show();
                        $('.focus-item').removeClass('focus-item');
                    },
                    errFn: function (data, status, xhr) {
                    }
                });
            }

        });
        //关闭下层
        $(document).on('click','.close-all',function(){
            $(this).addClass('to-all').removeClass('close-all').html('+');
            $(this).parent().parent().find('ul').hide();
        });
        //单选
        $(document).on('click','.depart-choose', function(){
            if($(this).is(":checked")){
                $('.depart-choose').prop('checked',false);
                $(this).prop('checked',true);
                var departId = $(this).val();
                var departName = $(this).parent().find('label').html();
                $('input[name="departId"]').val(departId);
                $('input[name="departName"]').val(departName);
            }else{
                $(this).prop('checked',false);
            }
        });

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
            acceptFileTypes: ['plain'],
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