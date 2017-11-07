require([
    'jquery', 'jquery.form.validator', 'jquery.datetimepicker'
], function ($) {


    // $.formUtils.addValidator({
    //     name: 'login',
    //     validatorFunction: function (value, $el, config, language, $form) {
    //         return value == ''
    //     },
    //     errorMessage: 'You have to answer an even number',
    //     errorMessageKey: 'tip'
    // });

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