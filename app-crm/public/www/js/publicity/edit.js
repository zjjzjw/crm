require([
    'jquery', 'jquery.form.validator'
], function ($) {

    $.validate({
        form: '#form',
        onSuccess: function ($form) {
            return true;
        }
    });

});