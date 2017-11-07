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
                "app/company/depart/edit",
                "app/partials/sidenav"
            ],
            "exclude": [
                "../js/common"
            ]
        },
        {
            "name": "../pages/company/depart/index",
            "include": [
                "app/company/depart/index",
                "app/partials/sidenav"
            ],
            "exclude": [
                "../js/common"
            ]
        },
        {
            "name": "../pages/company/detail",
            "include": [
                "app/company/detail",
                "app/partials/sidenav"
            ],
            "exclude": [
                "../js/common"
            ]
        },
        {
            "name": "../pages/company/product/category/edit",
            "include": [
                "app/company/product/category/edit",
                "app/partials/sidenav"
            ],
            "exclude": [
                "../js/common"
            ]
        },
        {
            "name": "../pages/company/product/category/index",
            "include": [
                "app/partials/sidenav"
            ],
            "exclude": [
                "../js/common"
            ]
        },
        {
            "name": "../pages/company/product/edit",
            "include": [
                "app/company/product/edit",
                "app/partials/sidenav"
            ],
            "exclude": [
                "../js/common"
            ]
        },
        {
            "name": "../pages/company/product/index",
            "include": [
                "app/partials/sidenav"
            ],
            "exclude": [
                "../js/common"
            ]
        },
        {
            "name": "../pages/company/rival/edit",
            "include": [
                "app/company/rival/edit",
                "app/partials/sidenav"
            ],
            "exclude": [
                "../js/common"
            ]
        },
        {
            "name": "../pages/company/rival/index",
            "include": [
                "app/partials/sidenav"
            ],
            "exclude": [
                "../js/common"
            ]
        },
        {
            "name": "../pages/company/role/edit",
            "include": [
                "app/company/role/edit",
                "app/partials/sidenav"
            ],
            "exclude": [
                "../js/common"
            ]
        },
        {
            "name": "../pages/company/role/index",
            "include": [
                "app/company/role/index",
                "app/partials/sidenav"
            ],
            "exclude": [
                "../js/common"
            ]
        },
        {
            "name": "../pages/company/sale/brand/edit",
            "include": [
                "app/company/sale/brand/edit",
                "app/partials/sidenav"
            ],
            "exclude": [
                "../js/common"
            ]
        },
        {
            "name": "../pages/company/sale/brand/index",
            "include": [
                "app/company/sale/brand/index",
                "app/partials/sidenav"
            ],
            "exclude": [
                "../js/common"
            ]
        },
        {
            "name": "../pages/company/sale/developer/edit",
            "include": [
                "app/company/sale/developer/edit",
                "app/partials/sidenav"
            ],
            "exclude": [
                "../js/common"
            ]
        },
        {
            "name": "../pages/company/sale/developer/index",
            "include": [
                "app/company/sale/developer/index",
                "app/partials/sidenav"
            ],
            "exclude": [
                "../js/common"
            ]
        },
        {
            "name": "../pages/company/sale/developer-group/edit",
            "include": [
                "app/company/sale/developer-group/edit",
                "app/partials/sidenav"
            ],
            "exclude": [
                "../js/common"
            ]
        },
        {
            "name": "../pages/company/sale/developer-group/index",
            "include": [
                "app/company/sale/developer-group/index",
                "app/partials/sidenav"
            ],
            "exclude": [
                "../js/common"
            ]
        },
        {
            "name": "../pages/company/sale/import",
            "include": [
                "app/company/sale/sale/import",
                "app/partials/sidenav"
            ],
            "exclude": [
                "../js/common"
            ]
        },
        {
            "name": "../pages/company/sale/large-area/edit",
            "include": [
                "app/company/sale/large-area/edit",
                "app/partials/sidenav"
            ],
            "exclude": [
                "../js/common"
            ]
        },
        {
            "name": "../pages/company/sale/large-area/index",
            "include": [
                "app/company/sale/large-area/index",
                "app/partials/sidenav"
            ],
            "exclude": [
                "../js/common"
            ]
        },
        {
            "name": "../pages/company/sale/sale/edit",
            "include": [
                "app/company/sale/sale/edit",
                "app/partials/sidenav"
            ],
            "exclude": [
                "../js/common"
            ]
        },
        {
            "name": "../pages/company/sale/sale/index",
            "include": [
                "app/company/sale/sale/index",
                "app/partials/sidenav"
            ],
            "exclude": [
                "../js/common"
            ]
        },
        {
            "name": "../pages/company/sale/sale-property/building",
            "include": [
                "app/company/sale/sale-property/building",
                "app/partials/sidenav"
            ],
            "exclude": [
                "../js/common"
            ]
        },
        {
            "name": "../pages/company/sale/sale-property/essential",
            "include": [
                "app/company/sale/sale-property/essential",
                "app/partials/sidenav"
            ],
            "exclude": [
                "../js/common"
            ]
        },
        {
            "name": "../pages/company/sale/sale-property/follow",
            "include": [
                "app/company/sale/sale-property/follow",
                "app/partials/sidenav"
            ],
            "exclude": [
                "../js/common"
            ]
        },
        {
            "name": "../pages/company/sale/sale-property/import",
            "include": [
                "app/company/sale/sale-property/import",
                "app/partials/sidenav"
            ],
            "exclude": [
                "../js/common"
            ]
        },
        {
            "name": "../pages/company/sale/sale-property/index",
            "include": [
                "app/company/sale/sale-property/index",
                "app/partials/sidenav"
            ],
            "exclude": [
                "../js/common"
            ]
        },
        {
            "name": "../pages/company/sale/sale-property/other",
            "include": [
                "app/company/sale/sale-property/other",
                "app/partials/sidenav"
            ],
            "exclude": [
                "../js/common"
            ]
        },
        {
            "name": "../pages/company/sale/sale-property/property",
            "include": [
                "app/company/sale/sale-property/property",
                "app/partials/sidenav"
            ],
            "exclude": [
                "../js/common"
            ]
        },
        {
            "name": "../pages/company/sale/sale-property/sales",
            "include": [
                "app/company/sale/sale-property/sales",
                "app/partials/sidenav"
            ],
            "exclude": [
                "../js/common"
            ]
        },
        {
            "name": "../pages/company/user/data",
            "include": [
                "app/company/user/data",
                "app/partials/sidenav"
            ],
            "exclude": [
                "../js/common"
            ]
        },
        {
            "name": "../pages/company/user/edit",
            "include": [
                "app/company/user/edit",
                "app/partials/sidenav"
            ],
            "exclude": [
                "../js/common"
            ]
        },
        {
            "name": "../pages/company/user/index",
            "include": [
                "app/company/user/index",
                "app/partials/sidenav"
            ],
            "exclude": [
                "../js/common"
            ]
        },
        {
            "name": "../pages/company/user/pwd",
            "include": [
                "app/company/user/pwd",
                "app/partials/sidenav"
            ],
            "exclude": [
                "../js/common"
            ]
        },
        {
            "name": "../pages/home/index",
            "include": [
                "app/home/index",
                "app/partials/sidenav"
            ],
            "exclude": [
                "../js/common"
            ]
        },
        {
            "name": "../pages/login",
            "include": [
                "app/login",
                "app/partials/sidenav"
            ],
            "exclude": [
                "../js/common"
            ]
        }
    ]
}