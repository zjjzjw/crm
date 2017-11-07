require([
    'jquery',
    'page.params',
    'lib/temp',
    'lib/popup',
    'component/area',
    'component/search',
    'app/service/company/sale/sale-property/essentialService',
    'component/ajax',
    'jquery.form.validator',
    'lib/autocomplete/autocomplete'
], function ($, params, temp, Popup, Area, Search, service ) {

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
                    window.location.href = '/company/sale/sale-property/essential/' + params.id;
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

    var area = new Area({'idNames': ['province_id', 'city_id', 'county_id'], 'data': params.areas});
    area.selectedId(params.province_id, params.city_id, params.county_id);

    //分公司下拉联想
    var autoComplete = new Search({
        keyword: '#keyword',
        resources: service.getEssentialByKeyword
    });

    autoComplete.on('search_box_selected', function (data, event) {
        $("input[name='developer_id']").val(data.item.id);
        renderInfo.call(this, data, event);
    });

    //项目跟进人下拉联想
    var autoComplete = new Search({
        keyword: '.project-keyword',
        resources: service.getProjectByKeyword
    });

    autoComplete.on('search_box_selected', function (data, event) {
        $("input[name='user_id']").val(data.item.id);
        renderInfo.call(this, data, event);
    });

    autoComplete.on('search_box_focus', function (data, event) {
        renderInfo.call(this, data, event);
    });

    function renderInfo(data, event) {
        var item = data.item;
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