<?php

return [
    // which service we depend
    // array<endpoint,names>
    'depends' => [
        env("ANGEJIA_ENDPOINT") => [
            'Angejia.Domain.Inventory.InventoryService',
            'Angejia.Domain.Image.ImageService',
            'Angejia.Domain.Common.City.CityService',
            'Angejia.Domain.Common.District.DistrictService',
            'Angejia.Domain.Common.Block.BlockService',
            'Angejia.Domain.Demand.MemberInventoryViewService',
            'Angejia.Domain.Demand.DemandService',
            'Angejia.Domain.User.UserService',
            'Angejia.Domain.Call.CallService',
            'Angejia.Domain.Sms.SmsService',
            'Angejia.Domain.Common.LightRail.LightRailService',
            'Angejia.Domain.Member.MemberDynamicService',
            'Angejia.Domain.Member.MemberDemandService',
            'Angejia.Domain.Message.MessageService',
            'Angejia.Domain.Push.PushService',
            'Angejia.Domain.NewAgent.CompanyService',
        ],
        env("ACCOUNT_ENDPOINT") => [
            'Account.Service.Account.AccountService',
            'Account.Service.Department.DepartmentService',
            'Account.Service.Job.JobService',
        ],
        env("RETRX_ENDPOINT") => [
            'Netrx.Domain.NewTransaction.NewTransactionRpcService',
        ],
    ],

    // which service we can provide
    // array<name,handler class>
    'providers' => [
    ],

];
