<?php

return [
    // which service we depend
    // array<endpoint,names>
    'depends' => [
        env("ANGEJIA_ENDPOINT") => [
            'Angejia.Domain.Image.ImageService',
            'Angejia.Domain.Common.City.CityService',
            'Angejia.Domain.Common.District.DistrictService',
            'Angejia.Domain.Common.Block.BlockService',
            'Angejia.Domain.Demand.MemberInventoryViewService',
            'Angejia.Domain.Call.CallService',
            'Angejia.Domain.Sms.SmsService',
            'Angejia.Domain.Common.LightRail.LightRailService',
            'Angejia.Domain.LightRail.LightRailLineService',
            'Angejia.Domain.LightRail.LightRailStationService',
            'Angejia.Domain.User.UserService',
        ],
        env("ACCOUNT_ENDPOINT") => [
            'Account.Service.Account.AccountService',
            'Account.Service.Department.DepartmentService',
        ],
    ],

    // which service we can provide
    // array<name,handler class>
    'providers' => [
    ],

];
