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
            "name": "../pages/company/depart/edit",
            "include": [
                "app/company/edit"
            ],
            "exclude": [
                "../js/common"
            ]
        },
        {
            "name": "../pages/company/depart/index",
            "include": [
                "app/company/depart/index"
            ],
            "exclude": [
                "../js/common"
            ]
        },
        {
            "name": "../pages/company/edit",
            "include": [
                "app/company/edit"
            ],
            "exclude": [
                "../js/common"
            ]
        },
        {
            "name": "../pages/company/index",
            "include": [
                "app/company/index"
            ],
            "exclude": [
                "../js/common"
            ]
        },
        {
            "name": "../pages/company/role/edit",
            "include": [
                "app/company/role/edit"
            ],
            "exclude": [
                "../js/common"
            ]
        },
        {
            "name": "../pages/company/role/index",
            "include": [
                "app/company/role/index"
            ],
            "exclude": [
                "../js/common"
            ]
        },
        {
            "name": "../pages/company/user/data",
            "include": [
                "app/company/user/data"
            ],
            "exclude": [
                "../js/common"
            ]
        },
        {
            "name": "../pages/company/user/edit",
            "include": [
                "app/company/user/edit"
            ],
            "exclude": [
                "../js/common"
            ]
        },
        {
            "name": "../pages/company/user/index",
            "include": [
                "app/company/user/index"
            ],
            "exclude": [
                "../js/common"
            ]
        },
        {
            "name": "../pages/company/user/pwd ",
            "include": [
                "app/company/user/pwd"
            ],
            "exclude": [
                "../js/common"
            ]
        },
        {
            "name": "../pages/home/index",
            "include": [
                "app/home/index"
            ],
            "exclude": [
                "../js/common"
            ]
        },
        {
            "name": "../pages/login",
            "include": [
                "app/login"
            ],
            "exclude": [
                "../js/common"
            ]
        },
        {
            "name": "../pages/publicity/edit",
            "include": [
                "app/publicity/edit"
            ],
            "exclude": [
                "../js/common"
            ]
        },
        {
            "name": "../pages/publicity/index",
            "include": [
                "app/publicity/index"
            ],
            "exclude": [
                "../js/common"
            ]
        },
        {
            "name": "../pages/suggestion/edit",
            "include": [
                "app/suggestion/edit"
            ],
            "exclude": [
                "../js/common"
            ]
        },
        {
            "name": "../pages/suggestion/index",
            "include": [
                "app/suggestion/index"
            ],
            "exclude": [
                "../js/common"
            ]
        }
    ]
}