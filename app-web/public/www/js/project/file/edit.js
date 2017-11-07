define([
    'zepto',
    'page.params',
    'backbone',
    'ui.popup',
    'validate',
    'zepto.temp',
    'app/service/project/fileService'
], function ($, params, Backbone, Popup, mvalidate, temp, service) {
    'use strict';

    var Edit = function () {
        var self = this;
        self.limitPop = new Popup({
            width: 250,
            height: 150,
            content: $('#limitTpl').html()
        });
        self.loadingPop = new Popup({
            content: $('#loadingTpl').html()
        });
        self.bindEvent();
    };

    Edit.prototype.bindEvent = function () {
        var self = this;
        $(document).on("click",".save-btn",function(){
            for(var i =0;i<$(".common-input-value").length; i++){
                var common=$(".common-input-value")[i].value;
            }
            for(var j =0;j<$(".model-input-value").length; j++){
                var model=$(".model-input-value")[j].value;
            }
            for(var k =0;k<$(".price-input-value").length; k++){
                var price=$(".price-input-value")[k].value;
            }
            if($(".history-input-value").val()==''){
                $(".historybrand-input-error").show()
            }else if(model==''){
                $(".historybrand-input-error").hide()
                $(".model-input-error").show()
            }else if (price==''){
                $(".model-input-error").hide()
                $(".price-input-error").show()
            }else if (isNaN(price)){
                $(".price-error").show()
            }else if($(".cooperation-input-value").val()==''){
                $(".price-error").hide()
                $(".price-input-error").hide()
                $(".cooperation-input-error").show()
            }else if(common ==''){
                $(".cooperation-input-error").hide()
                $(".common-input-error").show()
            }else if($(".bench-input-value").val()==''){
                $(".common-input-error").hide()
                $(".bench-input-error").show()
            }else{
                $(".bench-input-error").hide()
                self.loadingPop.showPop();
                service.storeProjectFile(
                    {
                        data: $('#form_creat').serialize(),
                        sucFn: function (data, status, xhr) {
                            self.loadingPop.closePop();
                            window.location.href = '/project/' + params.project_id + '/file/detail/' + data.id;
                        },
                        errFn: function (xhr, errorType, error) {
                            var message = showError(xhr);
                            $('.hint-content').empty().html(message);
                            self.loadingPop.closePop();
                            self.limitPop.showPop();
                        }
                    }
                );
            }
        });

        $('.limit-close').on('click', function () {
            self.limitPop.closePop();
            $('.hint-content').empty();
        });
    };
    new Edit();

    //新增产品
    $(document).on("click",".add-product i",function(){
        var tpl = temp('productTpl', {});
        $('.product-group').append(tpl);
        changeProduct();
    });

    //新增评价
    $(document).on("click",".add-common i",function(){
        var tpl = temp('commonTpl', {});
        $('.common-group').append(tpl);
        changeCommon();
    });

    //删除评价
    $(document).on("click","#common-move i",function(){
        $(this).parent().prev().prev().children('.common-input').last().remove();
        changeCommon();
    });

    //删除产品
    $(document).on("click","#product-move i",function(){
        $(this).parent().prev().prev().prev().prev().children('.product-input').last().remove();
        changeProduct();
    });


    //删除产品按钮出现判断
    function changeProduct(){
        if($('.product-input').children().hasClass("judge-product")){
            $("#product-move").show();
        }
        else{
            $("#product-move").hide();
        }
    }
    changeProduct();

    //删除评价按钮出现判断
    function changeCommon(){
        if($('.common-input').children().hasClass("judge-common")){
            $("#common-move").show();
        }
        else{
            $("#common-move").hide();
        }
    }
    changeCommon();


    function showError(data) {
        var info = '';
        var messages = [];
        var i = 0;
        for (var key in data) {
            messages.push(++i + "、" + data[key][0]);
        }
        info = messages.join('</br>');
        return info;
    }
});
