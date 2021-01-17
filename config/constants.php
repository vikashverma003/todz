<?php 
return [
    'APP_NAME' => 'Tod-Z',
    'APP_CURRENCY' => '$',
    'APP_ADDRESS'=>'Ahtri 12, 10151, Tallinn, Estonia',
    'role' =>   [
        'ADMIN' => 'admin',
        'TALENT' => 'talent',
        'CLIENT' => 'client'
    ],
    'account_status'=>[
        'IN_ACTIVE'=>0,
        'ACTIVE'=>1,
        'BLOCK'=>2,
        'DEACTIVATE_ACCOUNT'=>3
    ],
    'project_status'=>[
        'PENDING'=>'pending',
        'ACTIVE'=>'active',
        'COMPLETED'=>'completed',
        'IN-COMPLETE'=>'in-complete',
        'HIRED'=>'hired',
        'DISPUTE'=>'dispute',
    ],
    'entity'=>[
        'CORPORATE' => 'corporate',
        'INDIVIDUAL' => 'individual',
        'PRIVATE' => 'private'
    ],
    'project_talent_status'=>[
        'PENDING'=>0,
        'ACCEPTED'=>1,
        'REJECTED'=>2
    ],
    'milestone_status'=>[
        'PENDING' => 0,
        'APPROVED' => 1,
        'REJECTED'=>2
    ], 
    'profile'=>[
        'BASE_URL'=>'images/Profiles'
    ],
    'test_status'=>[
        'PENDING'=>0,
        'APPROVED'=>1,
        'DECLINED'=>2
    ],
    'CURRENCY'=>'USD',
    'PROJECT_ID_PREFIX'=>'PR_',
    'TRACKER_STATUS'=>[
        'PENDING'=>0,
        'START'=>1,
        'PAUSE'=>2
    ],
    'COUPON_TYPE' => [
        'BOTH' => 1,
        'CLIENT' => 2,
        'TALENT' => 3
    ],
    'ESCLARATION_STATUS'=>[
        'PENDING' => 0,
        'RESOLVED'=>1
    ],
    'hours'=>[
        'PENDING'=>0,
        'APPROVED'=>1,
        'DECLINED'=>2
    ],
    'timesheet_status'=>[
        'PENDING'=>0,
        'APPROVED'=>1,
        'DECLINED'=>2
    ],
    'invoice_country_codes'=>[
        'Estonia'=>"TOD/CLI/REC01",
        'USA'=>"TOD/CLI/REC02",
        'Canada'=>"TOD/CLI/REC03",
        'UK'=>"TOD/CLI/REC04",
        'Spain'=>"TOD/CLI/REC05",
        'Poland'=>"TOD/CLI/REC06",
        'Greece'=>"TOD/CLI/REC07",
        'India'=>"TOD/CLI/REC08",
    ],
    'europe_countries'=>[
        'Russia','Ukraine','France','Spain','Sweden','Norway','Germany','Finland','Poland','Italy','UK','Romania','Belarus','Kazakhstan','Greece','Bulgaria','Iceland','Hungary','Portugal','Austria','Czechia','Serbia','Ireland','Lithuania','Latvia','Croatia','Slovakia','Estonia','Denmark','Switzerland','Netherlands','Moldova','Belgium','Armenia','Albania','Turkey','Slovenia','Montenegro','Kosovo','Cyprus','Azerbaijan','Luxembourg','Georgia','Andorra','Malta','Liechtenstein','Monaco','Vatican City','San Marino'
    ],
];

    

    