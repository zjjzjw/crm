require([
    'jquery',
    'page.params',
    'lib/temp',
    'lib/popup',
    'app/service/company/sale/sale-property/otherService',
    'component/ajax',
    'jquery.form.validator'
], function ($, params, temp, Popup, service ) {

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
                    window.location.href = '/company/sale/sale-property/other/' + params.id;
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