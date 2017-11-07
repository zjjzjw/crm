require([
    'jquery',
    'lib/temp',
    'app/service/depart/departService',
], function ($,temp,service) {
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
        }else{
            //请求api
            $(this).parent().parent().addClass('first-request');
            service.level({
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
    $(document).on('click','input[name="depart_ids[]"]',function(){
        var ifNode = $(this).parent().parent().find('li').length;
        if(ifNode>0){
            if($(this).is(":checked")){
                $(this).prop("checked",true);
                $(this).parent().parent().find('input[name="depart_ids[]"]').prop("checked",true);
            }
        }else{
            if($(this).is(":checked")){
                $(this).prop("checked",true);
            }else{
                $(this).prop("checked",false);
                $(this).parents('.permission').find('input[name="depart_ids[]"]:first').prop("checked",false);
            }
        }
    });
});
