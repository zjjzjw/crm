require([
    'jquery', 'jquery.form.validator', 'jquery.datetimepicker'
], function ($) {

    $('.date').datetimepicker({
        timepicker: false,
        format: 'Y-m-d',
        formatDate: 'Y-m-d',
        closeOnDateSelect: true,
        scrollInput: false,
        lang: 'zh'
    });

});