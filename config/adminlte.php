<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | The default title of your admin panel, this goes into the title tag
    | of your page. You can override it per page with the title section.
    | You can optionally also specify a title prefix and/or postfix.
    |
    */

    'title' => 'Rogue-Two',

    'title_prefix' => 'RT - ',

    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | This logo is displayed at the upper left corner of your admin panel.
    | You can use basic HTML here if you want. The logo has also a mini
    | variant, used for the mini side bar. Make it 3 letters or so
    |
    */

    'logo' => '<b style="color:red">R</b>ogue-Two',

    'logo_mini' => '<b style="color:red">R</b>',

    /*
    |--------------------------------------------------------------------------
    | Skin Color
    |--------------------------------------------------------------------------
    |
    | Choose a skin color for your admin panel. The available skin colors:
    | blue, black, purple, yellow, red, and green. Each skin also has a
    | ligth variant: blue-light, purple-light, purple-light, etc.
    |
    */

    'skin' => 'yellow-light',

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Choose a layout for your admin panel. The available layout options:
    | null, 'boxed', 'fixed', 'top-nav'. null is the default, top-nav
    | removes the sidebar and places your menu in the top navbar
    |
    */

    'layout' => null,

    /*
    |--------------------------------------------------------------------------
    | Collapse Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we choose and option to be able to start with a collapsed side
    | bar. To adjust your sidebar layout simply set this  either true
    | this is compatible with layouts except top-nav layout option
    |
    */

    'collapse_sidebar' => false,

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Register here your dashboard, logout, login and register URLs. The
    | logout URL automatically sends a POST request in Laravel 5.3 or higher.
    | You can set the request to a GET or POST with logout_method.
    | Set register_url to null if you don't want a register link.
    |
    */

    'dashboard_url' => 'home',

    'logout_url' => 'logout',

    'logout_method' => 'POST',

    'login_url' => 'login',

    //'register_url' => 'register',
    'register_url' => null,

    'social_login' => false,

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Specify your menu items to display in the left sidebar. Each menu item
    | should have a text and and a URL. You can also specify an icon from
    | Font Awesome. A string instead of an array represents a header in sidebar
    | layout. The 'can' is a filter on Laravel's built in Gate functionality.
    |
    */

    'menu' => [
        'MAIN NAVIGATION',
        [
            'text' => 'Dashboard',
            'icon' => 'tachometer',
            'label_color' => 'danger',
            'icon_color'  => 'red',
            'permission' => 'view-dashboard',
            'submenu'   => [
                [
                    'text'  => 'Chart',
                    'url'   => 'dashboards',
                    'icon'  => 'pie-chart',
                    'icon_color' => 'red',
                    'permission' => 'view-chart',
                ],
                [
                    'text'  => 'Map',
                    'url'   => '#',
                    'icon'  => 'map',
                    'icon_color' => 'red',
                    'permission' => 'view-map',
                ],
                [
                    'text'  => 'Dashboard Purchase',
                    'url'   => '#',
                    'icon'  => 'bell',
                    'icon_color' => 'red',
                    'permission' => 'view-dashboard',
                ],
                [
                    'text'  => 'Dashboard Store',
                    'url'   => '#',
                    'icon'  => 'calculator',
                    'icon_color' => 'red',
                    'permission' => 'view-dashboard',
                ]
                
            ]
        ],
        '[SYSTEM ADMIN]',
        [
            'text'        => 'Authentications',
            'url'         => '#',
            'icon'        => 'key',
            'label_color' => 'success',
            'icon_color'  => 'green',
            'permission' => 'view-admin',
            'submenu'   => [
                [
                    'text'  => 'Users',
                    'url'   => 'users',
                    'icon'  => 'user',
                    'icon_color'  => 'green',
                    'permission' => 'view-user',
                ],
                [
                    'text'  => 'Roles',
                    'url'   => 'roles',
                    'icon'  => 'user-circle-o',
                    'icon_color'  => 'green',
                    'permission' => 'view-role',
                ],
                [
                    'text'  => 'Permissions',
                    'url'   => 'permissions',
                    'icon'  => 'handshake-o',
                    'icon_color'  => 'green',
                    'permission' => 'view-permission',
                ],
                [
                    'text'  => 'Teams',
                    'url'   => 'teams',
                    'icon'  => 'users',
                    'icon_color'  => 'green',
                    'permission' => 'view-team',
                ],
                [
                    'text'  => 'Activity Logs',
                    'url'   => 'activitylogs',
                    'icon_color'  => 'green',
                    'icon'  => 'font',
                    'permission' => 'view-activitylog',
                ],
                [
                    'text'  => 'Access Logs',
                    'url'   => 'accesslogs',
                    'icon_color'  => 'green',
                    'icon' => 'universal-access',
                    'permission' => 'view-accesslog',
                ],
                [
                    'text'  => 'Security Logs',
                    'url'   => 'securitylogs',
                    'icon_color'  => 'green',
                    'icon' => 'lock',
                    'permission' => 'view-securitylog',
                ],
            ]
        ],
        [
            'text' => 'Organizations',
            'icon'        => 'sitemap',
            'icon_color'  => 'orange',
            'permission' => 'view-organization',
            'submenu'     => [
                [
                    'text'  => 'Companies',
                    'url'   => 'companies',
                    'icon_color'  => 'orange',
                    'icon' => 'university ',
                    'permission' => 'view-company',
                ],
                [
                    'text'  => 'Departments',
                    'url'   => 'departments',
                    'icon'  => 'tags',
                    'icon_color'  => 'orange',
                    'permission' => 'view-department',
                ],
                [
                    'text'  => 'Locations',
                    'url'   => 'locations',
                    'icon_color'  => 'orange',
                    'icon' => 'map-marker',
                    'permission' => 'view-location',
                ],
                [
                    'text'  => 'Employees',
                    'url'   => 'employees',
                    'icon_color'  => 'orange',
                    'icon' => 'male',
                    'permission' => 'view-employee',
                ],
                [
                    'text'  => 'Positions',
                    'url'   => 'positions',
                    'icon_color' => 'orange',
                    'icon'  => 'bullseye',
                    'permission' => 'view-position',
                ],
                
            ]
        ],
        [
            'text'        => 'Setting',
            'icon'        => 'wrench',
            'icon_color'  => 'blue',
            'permission'  => 'view-organization',
             'submenu'    => [
                [
                    'text'  => 'Projects',
                    'url'   => 'projects',
                    'icon_color'  => 'blue',
                    'permission' => 'view-project',
                ],
                [
                    'text' => 'Warehouse',
                    'url'  => 'warehouse',
                    'icon_color' => 'blue',
                    'permission' => 'view-warehouse',
                ],
                [
                    'text'  => 'Cost center',
                    'url'   => '#',
                    'icon_color'  => 'blue',
                    'permission' => 'view-costcenter',
                ],
                [
                    'text'  => 'Account code',
                    'url'   => '#',
                    'icon_color'  => 'blue',
                    'permission' => 'view-accountcode',
                ],
                [
                    'text'  => 'Item unit',
                    'url'   => 'itemunits',
                    'icon_color'  => 'blue',
                    'permission' => 'view-item',
                ],
                [
                    'text'  => 'Item groups',
                    'url'   => 'itemgroups',
                    'icon_color'  => 'blue',
                    'permission' => 'view-itemgroup',
                ],
                [
                    'text'  => 'Item code',
                    'url'   => 'items',
                    'icon_color'  => 'blue',
                    'permission' => 'view-item',
                ],
             ]
        ],
        'APP',
        [
            'text' => 'Purchase Request',
            'url'  => '#',
            'icon' => 'shopping-cart',
            'icon_color'  => 'purple',
            'permission' => 'view-pr',
            'submenu'   => [
                [
                    'text'  => 'draft',
                    'url'   => 'pr/draft',
                    'icon_color'  => 'purple',
                    'permission' => 'view-pr',
                ],
                [
                    'text'  => 'inbox',
                    'url'   => 'pr/inbox',
                    'permission' => 'view-pr',
                ],
                [
                    'text'  => 'outbox',
                    'url'   => 'pr/outbox',
                    'permission' => 'view-pr',
                ]
            ]
        ],
        [
            'text' => 'Inventory',
            'url'  => '#',
            'icon_color'  => 'yellow',
            'icon' => 'calculator',
            'permission' => 'view-inventory',
            'submenu'   => [
                [
                    'text'  => 'Inventory Items',
                    'url'   => 'inventories',
                    'icon_color'  => 'yellow',
                    'icon' => 'archive',
                    'permission' => 'view-inventory',
                ],
                [
                    'text'  => 'Goods Receipt PO',
                    'url'   => 'inventories#/admin/goods_po/create',
                    'icon_color'  => 'yellow',
                    'icon' => 'check-square',
                    'permission' => 'view-inventory',
                ],
                [
                    'text'  => 'Goods Receipt',
                    'url'   => 'inventories#/admin/goods_receipt/create',
                    'icon_color'  => 'yellow',
                    'icon' => 'check-square',
                    'permission' => 'view-inventory',
                ],
                [
                    'text'  => 'Goods Return',
                    'url'   => 'inventories/goods_return',
                    'icon_color'  => 'yellow',
                    'icon' => 'undo',
                    'permission' => 'view-inventory',
                ],
                [
                    'text'  => 'Goods Issue',
                    'url'   => 'inventories/goods_issue',
                    'icon_color'  => 'yellow',
                    'icon' => 'exchange',
                    'permission' => 'view-inventory',
                ],
                [
                    'text'  => 'Transfer Items',
                    'url'   => 'inventories/transfer_item',
                    'icon_color'  => 'yellow',
                    'icon' => 'retweet',
                    'permission' => 'view-inventory',
                ],
                [
                    'text'  => 'Adjust Items',
                    'url'   => 'inventories/adjust_item',
                    'icon_color'  => 'yellow',
                    'icon' => 'adjust',
                    'permission' => 'view-inventory-adjust',
                ],
                [
                    'text'  => 'Daily Report',
                    'url'   => 'inventories/daily_report',
                    'icon_color'  => 'yellow',
                    'icon' => 'flag',
                    'permission' => 'view-inventory-report',
                ],
                [
                    'text'  => 'Summary Report',
                    'url'   => 'inventories/summary_report',
                    'icon_color'  => 'yellow',
                    'icon' => 'flag-checkered',
                    'permission' => 'view-inventory-report',
                ],
                
            ],
        ],
        [
            'text'       => 'Change Password',
            'icon_color' => 'red',
            'url'        => 'changepassword',
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Choose what filters you want to include for rendering the menu.
    | You can add your own filters to this array after you've created them.
    | You can comment out the GateFilter if you don't want to use Laravel's
    | built in Gate functionality
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SubmenuFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        //JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        App\MenuFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Choose which JavaScript plugins should be included. At this moment,
    | only DataTables is supported as a plugin. Set the value to true
    | to include the JavaScript file from a CDN via a script tag.
    |
    */

    'plugins' => [
        'datatables' => true,
        'select2'    => true,
        'chartjs'    => true,
    ],
];
