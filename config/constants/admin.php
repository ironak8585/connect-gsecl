<?php

return [
    'USER' => [
        'ROLES' => [
            'SUPER_ADMIN' => 'SUPER_ADMIN',
            'ADMIN' => 'ADMIN',
            'GUEST' => 'GUEST',
            'EMPLOYEE' => 'EMPLOYEE',
        ],
        'DEFAULT_ROLES' => [
            'ADMIN' => 'Administrator',
            'GUEST' => 'Guest',
        ],
        'STATUS' => [
            'ACTIVE' => 'ACTIVE',
            'INACTIVE' => 'INACTIVE',
            'BLOCKED' => 'BLOCKED',
        ],
    ],

    'EMPLOYEE' => [
        'CATEGORY' => [
            'T' => 'TECHNICAL',
            'NT' => 'NON-TECHNICAL',
        ],
        'CLASS' => [
            1 => 'I',
            2 => 'II',
            3 => 'III',
            4 => 'IV'
        ],
        'GENDER' => [
            'M' => 'MALE',
            'F' => 'FEMALE'
        ],
        'DISABILITY' => [
            'Y' => 'DISABLED',
            'N' => 'NOT-DISABLED',
        ],
        'CASTE' => [
            'GEN' => 'GENERAL',
            'SEBC' => 'SOCIALLY ECONOMIC BACKWARD CLASS',
            'SC' => 'SCHEDULED CASTE',
            'ST' => 'SCHEDULED TRIBE',
            'EWS' => 'ECONOMICALLY WEAKER SECTION',
        ],
        'QUALIFICATION_TYPE' => [
            'U' => 'UNDER-GRADUATED',
            'G' => 'GRADUATED',
            'PG' => 'POST-GRADUATED',
            'PHD' => 'PHD',
            'DIPLOMA' => 'DIPLOMA',
            'OTHER' => 'OTHER',
        ],
        'BLOODGROUP' => [
            'A+' => 'A+',
            'A-' => 'A-',
            'B+' => 'B+',
            'B-' => 'B-',
            'O+' => 'O+',
            'O-' => 'O-',
            'AB+' => 'AB+',
            'AB-' => 'AB-',
        ],
        'STATUS' => [
            'ACTIVE' => 'ACTIVE',
            'INACTIVE' => 'INACTIVE',
            'TERMINATED' => 'TERMINATED',
            'DEPUTATION' => 'DEPUTATION',
            'RETIRED' => 'RETIRED',
            'SUSPENDED' => 'SUSPENDED'
        ]
    ]
];