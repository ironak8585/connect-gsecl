<?php

return [
    'Master' => [
        'icon' => 'bi bi-files',
        'links' => [
            [
                'label' => 'Core Departments',
                'icon' => 'bi bi-circle',
                'route' => 'master.core_departments.index',
                'permission' => 'master_core_departments_read',
            ],
            [
                'label' => 'Sub Departments',
                'icon' => 'bi bi-circle',
                'route' => 'master.sub_departments.index',
                'permission' => 'master_sub_departments_read',
            ],
            [
                'label' => 'Departments',
                'icon' => 'bi bi-circle',
                'route' => 'master.departments.index',
                'permission' => 'master_departments_read',
            ],
            [
                'label' => 'Consent Categories',
                'icon' => 'bi bi-circle',
                'route' => '#',
                'permission' => 'master_consent_category_read',
            ],
        ],
    ],
    'Admin' => [
        'icon' => 'bi bi-person-bounding-box',
        'links' => [
            [
                'label' => 'Permissions',
                'icon' => 'bi bi-circle',
                'route' => 'admin.permissions.index',
                'permission' => 'admin_permissions_read',
            ],
            [
                'label' => 'Roles',
                'icon' => 'bi bi-circle',
                'route' => 'admin.roles.index',
                'permission' => 'admin_roles_read',
            ],
            [
                'label' => 'Users',
                'icon' => 'bi bi-circle',
                'route' => 'admin.users.index',
                'permission' => 'admin_users_read',
            ],
            [
                'label' => 'Employees',
                'icon' => 'bi bi-circle',
                'route' => 'admin.employees.index',
                'permission' => 'admin_employees_read',
            ],
            [
                'label' => 'Eurja Employees',
                'icon' => 'bi bi-circle',
                'route' => 'admin.eurja-employees.index',
                'permission' => 'admin_eurja_employee_read',
            ],
            [
                'label' => 'Import Employees',
                'icon' => 'bi bi-circle',
                'route' => 'admin.master-employees.import',
                'permission' => 'master_employee_import',   // rewrite properly
            ],
            [
                'label' => 'Eurja Departments',
                'icon' => 'bi bi-circle',
                'route' => 'admin.eurja_departments.index',
                'permission' => 'admin_eurja_departments_read',
            ],
        ],
    ],
    'Employees Master' => [
        'icon' => 'bi bi-people',
        'links' => [
            [
                'label' => 'Employees',
                'icon' => 'bi bi-circle',
                'route' => 'employee.master-employees.index',
                'permission' => 'master_employee_read',   // rewrite properly
            ],
            [
                'label' => 'Employees 2D',
                'icon' => 'bi bi-circle',
                'route' => 'employee.master-2d-employees.index',
                'permission' => 'master_2d_employee_read',
            ],
            [
                'label' => 'Master View',
                'icon' => 'bi bi-circle',
                'route' => 'employee.master-md-employees.index',
                'permission' => 'master_md_employee_read',
            ],
        ],
    ],
    'Location' => [
        'icon' => 'bi bi-building',
        'links' => [
            [
                'label' => 'Locations',
                'icon' => 'bi bi-circle',
                'route' => 'app.location.locations.index',
                'permission' => 'app_location_locations_read',
            ]
        ],
    ],
    'Content' => [
        'icon' => 'bi bi-file-earmark-text',
        'links' => [
            [
                'label' => 'Circulars',
                'icon' => 'bi bi-circle',
                'route' => 'app.content.circulars.index',
                'permission' => 'app_content_circular_read',
            ],
        ],
    ],
    'Request' => [
        'icon' => 'bi bi-stickies',
        'links' => [
            [
                'label' => 'Transfers Admin',
                'icon' => 'bi bi-circle',
                'route' => 'app.request.transfers.index',
                'permission' => 'app_request_transfer_read',
            ],
            [
                'label' => 'Transfers',
                'icon' => 'bi bi-circle',
                'route' => 'emp.request.transfers.index',
                'permission' => 'emp_request_transfer_read',
            ],
        ],
    ],
    'Technical' => [
        'icon' => 'bi bi-gear-fill',
        'links' => [
            [
                'label' => 'ABT',
                'icon' => 'bi bi-circle',
                'route' => '#',
                'permission' => '',
            ],
            [
                'label' => 'ASH',
                'icon' => 'bi bi-circle',
                'route' => '#',
                'permission' => '',
            ],
            [
                'label' => 'BOP',
                'icon' => 'bi bi-circle',
                'route' => '#',
                'permission' => '',
            ],
            [
                'label' => 'Boiler',
                'icon' => 'bi bi-circle',
                'route' => '#',
                'permission' => '',
            ],
            [
                'label' => 'Civil',
                'icon' => 'bi bi-circle',
                'route' => '#',
                'permission' => '',
            ],
            [
                'label' => 'Electrical',
                'icon' => 'bi bi-circle',
                'route' => '#',
                'permission' => '',
            ],
            [
                'label' => 'Environment',
                'icon' => 'bi bi-circle',
                'route' => '#',
                'permission' => '',
            ],
            [
                'label' => 'Energy Conservation',
                'icon' => 'bi bi-circle',
                'route' => '#',
                'permission' => '',
            ],
            [
                'label' => 'ESCI',
                'icon' => 'bi bi-circle',
                'route' => '#',
                'permission' => '',
            ],
            [
                'label' => 'ESCI Programs',
                'icon' => 'bi bi-circle',
                'route' => '#',
                'permission' => '',
            ],
            [
                'label' => 'Fuel',
                'icon' => 'bi bi-circle',
                'route' => '#',
                'permission' => '',
            ],
            [
                'label' => 'Technical Data',
                'icon' => 'bi bi-circle',
                'route' => '#',
                'permission' => '',
            ],
            [
                'label' => 'Wind Turbine',
                'icon' => 'bi bi-circle',
                'route' => '#',
                'permission' => '',
            ],
            [
                'label' => 'Turbine',
                'icon' => 'bi bi-circle',
                'route' => '#',
                'permission' => '',
            ],
        ],
    ],

];
