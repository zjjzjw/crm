require([
    'jquery',
    'jquery.form.validator'
], function ($) {
    var Login = function () {
        var self = this;
        self.init();
    };
    Login.prototype.init = function () {
        var self = this;
        $.validate({
            form: '#login-form',
            onSuccess: function ($form) {
                // $.ajax({
                //     type: 'POST',
                //     dataType: 'json',
                //     url: '',
                //     data: $form.serialize(),
                //     success: function (data) {
                //     },
                //     error: function (data) {
                //         window.location.href = '/';
                //     }
                // });
                return true;
            }
        });
    };
    new Login();

});