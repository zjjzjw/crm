require([
    'jquery', 'jquery.form.validator', 'jquery.datetimepicker'
], function ($) {

    $.validate({
        form: '#form',
        onSuccess: function ($form) {
            return true;
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

});