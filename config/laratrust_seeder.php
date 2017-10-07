<?php

return [
    'role_structure' => [
        'superadministrator' => [
        	'admin'=> 'c,r,u,d',
            'users' => 'c,r,u,d',
            'posts' => 'c,r,u,d',
        ],
        'author' => [
	        'users' => 'c,r,u,d',
            'posts' => 'c,r',
        ],
        'editor' => [
	        'users' => 'c,r,u,d',
            'posts' => 'r,u'
        ],
	    'guest' => [
		    'posts' => 'r'
	    ]
    ],
    'permission_structure' => [
        'superadministrator' => [
            'profile' => 'c,r,u,d'
        ],
    ],
    'permissions_map' => [
        'c' => 'ایجاد',
        'r' => 'خواندن',
        'u' => 'ویرایش',
        'd' => 'حذف'
    ]
];
