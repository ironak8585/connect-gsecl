<?php

// Get permissions with roles
$permissions = [
    'ADMIN' => [
        'admin_permissions_read',
        'admin_roles_read',
        'admin_roles_manage',
        'admin_users_manage',
        'user_profile'
    ],

    'EMPLOYEE' => [
        'emp_request_transfer_read',
        'emp_request_transfer_manage'
    ]
];

return $permissions;