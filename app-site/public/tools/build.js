{
    "appDir": "../www",
    "dir": "../www-built",
    "mainConfigFile": "../www/js/common.js",
    "logLevel": 2,
    "paths": {
        "page.params": "empty:"
    },
    "useStrict": true,
    "removeCombined": true,
    "findNestedDependencies": true,
    "optimizeCss": "standard",
    "waitSeconds": 0,
    "modules": [
        {
            "name": "../js/common",
            "include": [
                "jquery",
                "jquery.datetimepicker",
                "jquery.ui.widget",
                "jquery.fileupload",
                "jquery.form.validator"
            ]
        },
        {
            "name": "../pages/home",
            "include": [],
            "exclude": [
                "../js/common"
            ]
        },
        {
            "name": "../pages/product",
            "include": [],
            "exclude": [
                "../js/common"
            ]
        }
    ]
}