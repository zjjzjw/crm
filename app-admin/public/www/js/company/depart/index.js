require([
    'jquery',
    'lib/temp',
    'app/service/depart/departService',
    'lib/popup'
], function ($,temp,service,Popup) {

    $nodeBoxPop = new Popup({
        width: 400,
        height: 225,
        contentBg: '#fff',
        maskColor: '#000',
        maskOpacity: '0.6',
        content: $('#nodeBoxTpl').html()
    });
    $editBoxPop = new Popup({
        width: 400,
        height: 225,
        contentBg: '#fff',
        maskColor: '#000',
        maskOpacity: '0.6',
        content: $('#editBoxTpl').html()
    });

    //css
    $('.first-level-box .level-item:first').children().eq(0).css("line-height","17px").next().css("top","0");

    //显示下层
    $(document).on('click', '.to-all', function () {
        var id = $(this).data('id');
        $(this).parent().parent().addClass('focus-item');
        $(this).parent().parent().find('ul').remove();
        service.level({
            data: {id: id},
            sucFn: function (data, status, xhr) {
                var html = temp('node_tpl', {result:data});
                $('.focus-item').append(html);
                $('.focus-item').find('span:first').addClass('close-all').removeClass('to-all').html('—');
                if($('.focus-item').find('ul').find('li').length>0){
                    $('.focus-item').find('ul').show();
                }else{
                    $('.focus-item').find('ul').remove();
                }
                $('.focus-item').removeClass('focus-item');
            },
            errFn: function (data, status, xhr) {
            }
        });
    });
    $(document).on('click','.close-all',function(){
        $(this).addClass('to-all').removeClass('close-all').html('+');
        $(this).parent().parent().find('ul').remove();
    });

    //添加
    $(document).on('click','.add',function(){
        var nodeId = $(this).data('nodeid');
        var parentNmae = $(this).data('nodename');
        $('input[name="id"]').val(nodeId);
        $('.parent-name').html(parentNmae);
        $(this).parent().parent().addClass('focus-item-node');
        $nodeBoxPop.showPop();
    });
    $(document).on('click','.save-add',function(){
        var nodeName = $('.add-node').val();
        var parent_id = $('input[name="id"]').val();
        console.log(parent_id);
        if(nodeName== ''){
            $('.node-error').show();
        }else{
            $('.node-error').hide();
            service.addNode({
                data:{
                    id:0,
                    parent_id: parent_id,
                    name: nodeName
                },
                sucFn: function(data, status, xhr){
                    service.level({
                        data: {id: parent_id},
                        sucFn: function (data, status, xhr) {
                            var html = temp('node_tpl', {
                                result:data,
                            });
                            $('.focus-item-node').find('ul').remove();
                            $('.focus-item-node').append(html);
                            $('.focus-item-node').find('span:first').addClass('close-all').removeClass('to-all').html('—');
                            $('.focus-item-node').removeClass('focus-item-node');
                        },
                        errFn: function (data, status, xhr) {
                        }
                    });
                     $nodeBoxPop.closePop();
                     $('.add-node').val('');
                     $('.node-error').hide();
                },
                errFn: function(data, status, xhr){
                }
            });
        }
    });
    //取消添加
    $(document).on('click','.add-close',function(){
        $nodeBoxPop.closePop();
        $('.add-node').val('');
        $('.node-error').hide();
    });
    //编辑
    $(document).on('click','.edit',function(){
        var editId = $(this).data('nodeid');
        var parentId = $(this).data('parentid');
        var editType = $(this).parent().parent().find('p:first').find('span').html();
        $('input[name="editid"]').val(editId);
        $('input[name="edittype"]').val(editType);
        $('input[name="parentid"]').val(parentId);
        $(this).parent().parent().addClass('focus-item-node');
        $editBoxPop.showPop();
    });
    $(document).on('click','.save-edit',function(){
        var editName = $('.edit-name').val();
        var id = $('input[name="editid"]').val();
        var type = $('input[name="edittype"]').val();
        var parentid = $('input[name="parentid"]').val();
        if(editName==''){
            $('.node-error').show();
        }else{
            $('.node-error').hide();
            service.edit({
                data: {
                    id: id,
                    name: editName,
                    parent_id: parentid,
                },
                sucFn: function(data, status, xhr){
                    if(type=='+'){
                             $('.focus-item-node').find('p:first').html('<span class="left-icon first-requst to-all" data-id='+id+'>+</span>'+editName);
                    }else{
                         $('.focus-item-node').find('p:first').html('<span class="left-icon first-requst  close-all" data-id='+id+'>—</span>'+editName);
                    }
                    $editBoxPop.closePop();
                    $('.focus-item-node').removeClass('focus-item-node');
                    $('.edit-name').val('');
                },
                error: function(data, status, xhr){
                }
            });
        }
    });
    //取消编辑
    $(document).on('click','.edit-close',function(){
        $editBoxPop.closePop();
        $('.edit-name').val('');
        $('.node-error').hide();
    });
    //删除
    $(document).on('click','.delete',function(){
        var deleteId = $(this).data('nodeid');
        $(this).addClass('focus-item-node');
        service.deleteitem({
            data:{
                id: deleteId,
            },
            sucFn: function(data, status, xhr){
                if($('.focus-item-node').parent().parent().next('li').length>=1 || $('.focus-item-node').parent().parent().prev('li').length>=1){
                    $('.focus-item-node').parent().parent().remove();
                }else{
                    $('.focus-item-node').parent().parent().parent().remove();
                }
            },
            errFn: function(data, status, xhr){
            }
        });
    });
});