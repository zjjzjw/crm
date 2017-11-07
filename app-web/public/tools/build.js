{
    "appDir": "../www",
    "dir": "../www-built",
    "mainConfigFile": "../www/common.js",
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
            "name": "../common",
            "include": [
                "lib/almond",
                "fastclick",
                "zepto",
                "utils",
                "zepto.temp",
                "zepto.sp",
                "ajax",
                "validate",
                "app/lib/detect",
                "app/modules/event/track.link",
                "app/modules/event/track.event"
            ]
        },
        {
            "name": "../card.edit",
            "include": [
                "app/card/edit"
            ],
            "exclude": [
                "../common"
            ]
        },
        {
            "name": "../common.mobile",
            "include": [
                "zepto"
            ],
            "exclude": [
                "../common"
            ]
        },
        {
            "name": "../contract.detail",
            "include": [
                "app/contract/detail"
            ],
            "exclude": [
                "../common"
            ]
        },
        {
            "name": "../contract.edit",
            "include": [
                "app/contract/edit"
            ],
            "exclude": [
                "../common"
            ]
        },
        {
            "name": "../contract.list",
            "include": [
                "app/contract/list",
                "ui.autocomplete"
            ],
            "exclude": [
                "../common"
            ]
        },
        {
            "name": "../contract.payment-schedule",
            "include": [
                "app/contract/payment-schedule",
                "ui.autocomplete"
            ],
            "exclude": [
                "../common"
            ]
        },
        {
            "name": "../contract.payment.detail",
            "include": [
                "app/contract/payment/detail"
            ],
            "exclude": [
                "../common"
            ]
        },
        {
            "name": "../contract.payment.edit",
            "include": [
                "app/contract/payment/edit"
            ],
            "exclude": [
                "../common"
            ]
        },
        {
            "name": "../contract.payment.list",
            "include": [
                "app/contract/payment/list"
            ],
            "exclude": [
                "../common"
            ]
        },
        {
            "name": "../contract.signed-progress",
            "include": [
                "app/contract/signed-progress",
                "ui.autocomplete"
            ],
            "exclude": [
                "../common"
            ]
        },
        {
            "name": "../customer.detail",
            "include": [
                "app/customer/detail"
            ],
            "exclude": [
                "../common"
            ]
        },
        {
            "name": "../customer.edit",
            "include": [
                "app/customer/edit"
            ],
            "exclude": [
                "../common"
            ]
        },
        {
            "name": "../customer.list",
            "include": [
                "app/customer/list",
                "ui.autocomplete"
            ],
            "exclude": [
                "../common"
            ]
        },
        {
            "name": "../customer.structure.detail",
            "include": [
                "app/customer/structure/detail"
            ],
            "exclude": [
                "../common"
            ]
        },
        {
            "name": "../customer.structure.edit",
            "include": [
                "app/customer/structure/edit"
            ],
            "exclude": [
                "../common"
            ]
        },
        {
            "name": "../customer.structure.flow",
            "include": [
                "app/customer/structure/flow"
            ],
            "exclude": [
                "../common"
            ]
        },
        {
            "name": "../detail",
            "include": [
                "app/newhouse/detail",
                "app/modules/ui/inventory/communityInfo",
                "app/header"
            ],
            "exclude": [
                "../common"
            ]
        },
        {
            "name": "../error",
            "include": [],
            "exclude": [
                "../common"
            ]
        },
        {
            "name": "../help.list",
            "include": [],
            "exclude": [
                "../common"
            ]
        },
        {
            "name": "../home.index",
            "include": [],
            "exclude": [
                "../common"
            ]
        },
        {
            "name": "../houseType",
            "include": [
                "app/newhouse/houseType",
                "app/header"
            ],
            "exclude": [
                "../common"
            ]
        },
        {
            "name": "../list",
            "include": [
                "app/newhouse/list",
                "ui.autocomplete",
                "app/header"
            ],
            "exclude": [
                "../common"
            ]
        },
        {
            "name": "../login",
            "include": [
                "app/login"
            ],
            "exclude": [
                "../common"
            ]
        },
        {
            "name": "../map-loupan",
            "include": [
                "app/map-loupan",
                "app/header"
            ],
            "exclude": [
                "../common"
            ]
        },
        {
            "name": "../message.detail",
            "include": [
                "ui.autocomplete"
            ],
            "exclude": [
                "../common"
            ]
        },
        {
            "name": "../message.index",
            "include": [
                "ui.autocomplete"
            ],
            "exclude": [
                "../common"
            ]
        },
        {
            "name": "../message.list",
            "include": [
                "ui.autocomplete"
            ],
            "exclude": [
                "../common"
            ]
        },
        {
            "name": "../product.sorts.list",
            "include": [
                "app/product/sorts/list"
            ],
            "exclude": [
                "../common"
            ]
        },
        {
            "name": "../project.aim.detail",
            "include": [
                "app/project/aim/detail",
                "ui.morelink"
            ],
            "exclude": [
                "../common"
            ]
        },
        {
            "name": "../project.aim.edit",
            "include": [
                "app/project/aim/edit"
            ],
            "exclude": [
                "../common"
            ]
        },
        {
            "name": "../project.aim.hinder.detail",
            "include": [
                "app/project/aim/hinder/detail"
            ],
            "exclude": [
                "../common"
            ]
        },
        {
            "name": "../project.aim.hinder.edit",
            "include": [
                "app/project/aim/hinder/edit"
            ],
            "exclude": [
                "../common"
            ]
        },
        {
            "name": "../project.aim.hinder.list",
            "include": [
                "ui.autocomplete"
            ],
            "exclude": [
                "../common"
            ]
        },
        {
            "name": "../project.aim.main",
            "include": [
                "app/project/aim/main",
                "ui.autocomplete",
                "ui.morelink"
            ],
            "exclude": [
                "../common"
            ]
        },
        {
            "name": "../project.aim.progress",
            "include": [
                "app/project/aim/progress",
                "ui.morelink"
            ],
            "exclude": [
                "../common"
            ]
        },
        {
            "name": "../project.analyse.common-detail",
            "include": [
                "app/project/analyse/common-detail",
                "ui.morelink"
            ],
            "exclude": [
                "../common"
            ]
        },
        {
            "name": "../project.analyse.common-edit",
            "include": [
                "app/project/analyse/common-edit"
            ],
            "exclude": [
                "../common"
            ]
        },
        {
            "name": "../project.analyse.common-list",
            "include": [
                "app/project/analyse/common-list",
                "ui.autocomplete",
                "ui.morelink"
            ],
            "exclude": [
                "../common"
            ]
        },
        {
            "name": "../project.analyse.detail",
            "include": [
                "app/project/analyse/detail",
                "ui.morelink"
            ],
            "exclude": [
                "../common"
            ]
        },
        {
            "name": "../project.detail",
            "include": [
                "app/project/detail",
                "ui.morelink"
            ],
            "exclude": [
                "../common"
            ]
        },
        {
            "name": "../project.edit",
            "include": [
                "app/project/edit"
            ],
            "exclude": [
                "../common"
            ]
        },
        {
            "name": "../project.file.detail",
            "include": [
                "app/project/file/detail",
                "ui.morelink"
            ],
            "exclude": [
                "../common"
            ]
        },
        {
            "name": "../project.file.edit",
            "include": [
                "app/project/file/edit"
            ],
            "exclude": [
                "../common"
            ]
        },
        {
            "name": "../project.list",
            "include": [
                "app/project/list",
                "ui.autocomplete"
            ],
            "exclude": [
                "../common"
            ]
        },
        {
            "name": "../project.purchase.detail",
            "include": [
                "app/project/purchase/detail",
                "ui.morelink"
            ],
            "exclude": [
                "../common"
            ]
        },
        {
            "name": "../project.purchase.edit",
            "include": [
                "app/project/purchase/edit"
            ],
            "exclude": [
                "../common"
            ]
        },
        {
            "name": "../project.purchase.list",
            "include": [
                "app/project/purchase/list",
                "ui.autocomplete",
                "ui.morelink"
            ],
            "exclude": [
                "../common"
            ]
        },
        {
            "name": "../project.structure.detail",
            "include": [
                "app/project/structure/detail",
                "ui.morelink"
            ],
            "exclude": [
                "../common"
            ]
        },
        {
            "name": "../project.structure.edit",
            "include": [
                "app/project/structure/edit"
            ],
            "exclude": [
                "../common"
            ]
        },
        {
            "name": "../project.structure.flow",
            "include": [
                "app/project/structure/flow",
                "ui.morelink"
            ],
            "exclude": [
                "../common"
            ]
        },
        {
            "name": "../project.task-manifest",
            "include": [
                "app/project/task-manifest",
                "ui.autocomplete"
            ],
            "exclude": [
                "../common"
            ]
        },
        {
            "name": "../sale.detail",
            "include": [
                "app/sale/detail"
            ],
            "exclude": [
                "../common"
            ]
        },
        {
            "name": "../sale.edit",
            "include": [
                "app/sale/edit"
            ],
            "exclude": [
                "../common"
            ]
        },
        {
            "name": "../sale.list",
            "include": [
                "app/sale/list",
                "ui.autocomplete"
            ],
            "exclude": [
                "../common"
            ]
        },
        {
            "name": "../user.approval.detail",
            "include": [
                "app/user/approval/hinder/detail"
            ],
            "exclude": [
                "../common"
            ]
        },
        {
            "name": "../user.approval.hinder.list",
            "include": [
                "app/user/approval/hinder/list",
                "ui.autocomplete"
            ],
            "exclude": [
                "../common"
            ]
        },
        {
            "name": "../user.approval.sale.detail",
            "include": [
                "app/user/approval/sale/detail"
            ],
            "exclude": [
                "../common"
            ]
        },
        {
            "name": "../user.approval.sale.list",
            "include": [
                "app/user/approval/sale/list",
                "ui.autocomplete"
            ],
            "exclude": [
                "../common"
            ]
        },
        {
            "name": "../user.card.detail",
            "include": [
                "app/user/card/detail"
            ],
            "exclude": [
                "../common"
            ]
        },
        {
            "name": "../user.card.list",
            "include": [
                "app/user/card/list",
                "ui.autocomplete"
            ],
            "exclude": [
                "../common"
            ]
        },
        {
            "name": "../user.contacts.detail",
            "include": [],
            "exclude": [
                "../common"
            ]
        },
        {
            "name": "../user.contacts",
            "include": [
                "app/user/contacts"
            ],
            "exclude": [
                "../common"
            ]
        },
        {
            "name": "../user.opinion",
            "include": [
                "app/user/opinion"
            ],
            "exclude": [
                "../common"
            ]
        },
        {
            "name": "../user.set",
            "include": [
                "app/user/set"
            ],
            "exclude": [
                "../common"
            ]
        },
        {
            "name": "../user.sign-task.distribution",
            "include": [
                "app/user/sign-task/distribution",
                "ui.autocomplete"
            ],
            "exclude": [
                "../common"
            ]
        },
        {
            "name": "../user.sign-task.edit",
            "include": [
                "app/user/sign-task/edit"
            ],
            "exclude": [
                "../common"
            ]
        }
    ]
}