require([
    'jquery', 'jquery.form.validator', 'jquery.datetimepicker'
], function ($) {
    $.validate({
        form: '#form',
        onSuccess: function ($form) {
            return true;
        }
    });

});