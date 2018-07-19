<?php

return [
    'role_structure' => [
        'superadmin' => [
            'booking' => 'c,r,u,d',
            'room' => 'c,r,u,d',
            'user' => 'c,r,u,d',
            'security' => 'c,r,u,d',
        ],
        'admin' => [
            'booking' => 'c,r,u,d',
            'room' => 'c,r,u,d',
            'user' => 'c,r,u,d',
        ],
        'user' => [
            'booking' => 'c,r,u,d',
            'room' => 'r',
        ],
    ],
    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete'
    ]
];
