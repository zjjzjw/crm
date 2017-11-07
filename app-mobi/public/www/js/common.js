//The build will inline common dependencies into this file.
requirejs.config({
    baseUrl: 'js',
    paths: {
        app: '../js',
        // Files
        common: '../common',
        'jquery': 'lib/jquery/jquery.min',
        'jquery.datetimepicker': 'lib/datetimepicker/jquery.datetimepicker',
        'jquery.ui.widget': 'lib/jquery-file-upload/js/vendor/jquery.ui.widget',
        'jquery.fileupload': 'lib/jquery-file-upload/js/jquery.fileupload',
        'jquery.form.validator': 'lib/jquery-form-validator/jquery.form-validator'
    },
    shim: {
        'jquery.ui.widget': ['jquery'],
        'jquery.datetimepicker': ['jquery'],
        'jquery.fileupload': ['jquery'],
        'jquery.form.validator': ['jquery'],
    }
});