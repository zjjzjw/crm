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
                return true;
            }
        });
    };
    new Login();
});