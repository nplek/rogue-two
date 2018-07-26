<?php

return [
    'role_structure' => [
        'super' => [
            'users' => 'c,r,u,d,s,r,a',
            'acl' => 'c,r,u,d',
            'profile' => 'r,u',
            'company' => 'c,r,u,d,s,r,a'
        ],
        'admin' => [
            'users' => 'c,r,u,d',
            'profile' => 'r,u',
            'company' => 'c,r,u,d,s,r,a'
        ],
        'user' => [
            'profile' => 'r,u'
        ],
    ],
    'permission_structure' => [
        'cru_user' => [
            'profile' => 'c,r,u'
        ],
    ],
    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete',
        's' => 'restore',
        'r' => 'review',
        'a' => 'approval'
    ]
];
