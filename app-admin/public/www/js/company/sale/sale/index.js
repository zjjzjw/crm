require([
    'jquery',
    'lib/popup',
    'lib/temp',
    'jquery.form.validator',
    'jquery.datetimepicker'
], function ($, Popup) {


    var delete_url;
    // 企业证书轮播图
    $confirmPop = new Popup({
        width: 400,
        height: 225,
        contentBg: '#fff',
        maskColor: '#000',
        maskOpacity: '0.6',
        content: $('#confirmTpl').html()
    });

    $(document).on('click', '#dialog_cancel', function () {
        $confirmPop.closePop();
    });
    $(document).on('click', '#dialog_confirm', function () {
        $confirmPop.closePop();
        window.location.href = delete_url;
    });


    $('.delete').on('click', function () {
        $confirmPop.showPop();
        delete_url = $(this).attr('href');
        return false;
    });
});