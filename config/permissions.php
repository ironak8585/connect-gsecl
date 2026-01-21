<?php

$permissions = [

    /** Admin */

    // Permissions
    ["admin_permissions_read", "web", "View Permissions"],
    ["admin_permissions_manage", "web", "Manage Permissions"],

    // Roles
    ["admin_roles_read", "web", "View Roles"],
    ["admin_roles_manage", "web", "Manage Roles"],

    // Users
    ["admin_users_read", "web", "Read Users"],
    ["admin_users_manage", "web", "Manage Users"],
    ["user_profile", "web", "Update User Profile"], // Recheck
    ["my_profile_read", "web", "View Profile"],
    ["my_profile_manage", "web", "Manage Profile"],

    // Admin EUrja Data Sync
    ["admin_eurja_employee_sync", "web", "Sync Admin eUrja Employees"],
    ["admin_eurja_employee_manage", "web", "Manage Admin eUrja Employees"],
    ["admin_eurja_employee_read", "web", "Read Admin eUrja Employees"],
    ["admin_eurja_departments_read", "web", "Read Admin eUrja Departments"],
    ["admin_eurja_departments_manage", "web", "Manage Admin eUrja Departments"],

    // Master Employee Import
    ["master_employee_import", "web", "Import Master Employees"],
    ["master_departments_read", "web", "View Master Departments"],
    ["master_departments_manage", "web", "Manage Master Departments"],
    ["master_core_departments_read", "web", "Read Master Core Departments"],
    ["master_core_departments_manage", "web", "Manage Master Core Departments"],
    ["master_sub_departments_read", "web", "Read Master Sub Departments"],
    ["master_sub_departments_manage", "web", "Manage Master Sub Departments"],

    // Employee Module Masters
    ["master_employee_read", "web", "View Master Employees"],
    ["master_employee_manage", "web", "Manage Master Employees"],

    // Employee Module
    ["employee_employees_read", "web", "Read Employees"],

    // Master Employees
    ["master_2d_employee_read", "web", "View Master 2D Employees"],
    ["master_2d_employee_manage", "web", "Manage Master 2D Employees"],

    // Content - Circulars
    ["app_content_circular_read", "web", "View Circulars"],
    ["app_content_circular_manage", "web", "Manage Circulars"],


    // Request - Transfers
    ["emp_request_transfer_read", "web", "Manage Transfer Request"],
    ["emp_request_transfer_manage", "web", "View Transfer Request"],

    // 'app' => [
    //     'content' => [
    //         'circular' => [
    //             ["app_content_circular_read", "web", "View Circulars"],
    //             ["app_content_circular_manage", "web", "Manage Circulars"],

    //         ]
    //     ],
    //     'request' => [
    //         'transfer' => [
    //             ["app_request_transfer_read", "web", "View Transfer Request"],
    //             ["app_request_transfer_manage", "web", "Manage Transfer Request"],
    //         ]
    //     ]
    // ]
];

return $permissions;