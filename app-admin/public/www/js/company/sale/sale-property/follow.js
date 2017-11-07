require([
    'jquery',
    'page.params',
    'lib/temp',
    'lib/popup',
    'component/search',
    'app/service/company/sale/sale-property/followService',
    'component/ajax',
    'jquery.form.validator',
    'lib/autocomplete/autocomplete',
    'lib/datetimepicker/jquery.datetimepicker'
], function ($, params, temp, Popup, Search, service ) {

    $successPop = new Popup({
        width: 200,
        height: 150,
        contentBg: '#fff',
        maskColor: '#000',
        maskOpacity: '0.6',
        content: $('#successTpl').html()
    });
    $loadingPop = new Popup({
        width: 128,
        height: 128,
        contentBg: 'transparent',
        maskColor: '#000',
        maskOpacity: '0.6',
        content: $('#loadingTpl').html()
    });

    $promptPop = new Popup({
        width: 400,
        height: 225,
        contentBg: '#fff',
        maskColor: '#000',
        maskOpacity: '0.6',
        content: $('#promptTpl').html()
    });

    //预估项目合同签约时间
    $('input[name="project_estimate_signed_time"]').datetimepicker({
        timepicker: false,
        format: 'Y-m-d H:i:s',
        formatTime: 'H:i:s',
        formatDate: 'Y/m/d',
        closeOnDateSelect: true,
        scrollInput: false,
        lang: 'zh'
    });

    $.validate({
        form: '#form',
        onSuccess: function ($form) {
            moreValidate();
            return false;
        }
    });

    function moreValidate() {
        service.store({
            data: $('#form').serialize(),
            params: params,
            beforeSend: function () {
                $loadingPop.showPop();
            },
            sucFn: function (data, status, xhr) {
                $loadingPop.closePop();
                $successPop.showPop();
                setTimeout(skipStore, 2000);
                function skipStore() {
                    $successPop.closePop();
                    window.location.href = '/company/sale/sale-property/follow/' + params.id;
                }
            },
            errFn: function (data, status, xhr) {
                $loadingPop.closePop();
                $('.text').html(showError(data));
                $promptPop.showPop();
            }
        });
    }

    $(document).on('click', '#pop_close', function () {
        $promptPop.closePop();
    });


    //项目跟进人下拉联想
    var autoComplete = new Search({
        keyword: '#keyword',
        resources: service.getCompanyByKeyword
    });

    autoComplete.on('search_box_selected', function (data, event) {
        $("input[name='developer_group_id']").val(data.item.id);
        renderInfo.call(this, data, event);
    });

    autoComplete.on('search_box_focus', function (data, event) {
        renderInfo.call(this, data, event);
    });

    function renderInfo(data, event) {
        var item = data.item.name;
    }

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