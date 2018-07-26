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

    'logout_method' => null,

    'login_url' => 'login',

    'register_url' => 'register',
    //'register_url' => '',

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
            'label'       => 4,
            'label_color' => 'danger',
            'icon_color'  => 'red',
            'submenu'   => [
                [
                    'text'  => 'Chart',
                    'url'   => 'dashboards',
                    'icon'  => 'pie-chart',
                    'icon_color' => 'red',
                ],
                [
                    'text'  => 'Map',
                    'url'   => '#',
                    'icon'  => 'map',
                    'icon_color' => 'red',
                ],
                [
                    'text'  => 'Dashboard Purchase',
                    'url'   => '#',
                    'icon'  => 'bell',
                    'icon_color' => 'red',
                ],
                [
                    'text'  => 'Dashboard Store',
                    'url'   => '#',
                    'icon'  => 'calculator',
                    'icon_color' => 'red',
                ]
                
            ]
        ],
        '[SYSTEM ADMIN]',
        [
            'text'        => 'Authentications',
            'url'         => '#',
            'icon'        => 'key',
            'label'       => 6,
            'label_color' => 'success',
            'icon_color'  => 'green',
            'submenu'   => [
                [
                    'text'  => 'Users',
                    'url'   => 'users',
                    'icon'  => 'user',
                    'icon_color'  => 'green',
                ],
                [
                    'text'  => 'Roles',
                    'url'   => 'roles',
                    'icon_color'  => 'green',
                ],
                [
                    'text'  => 'Permissions',
                    'url'   => 'permissions',
                    'icon'  => 'handshake-o',
                    'icon_color'  => 'green',
                ],
                [
                    'text'  => 'Teams',
                    'url'   => 'teams',
                    'icon'  => 'users',
                    'icon_color'  => 'green',
                ],
                [
                    'text'  => 'Log Activity',
                    'url'   => 'log_activity',
                    'icon_color'  => 'green',
                    'icon'  => 'font',
                ],
                [
                    'text'  => 'Log Access',
                    'url'   => 'log_access',
                    'icon_color'  => 'green',
                    'icon' => 'universal-access',
                ],
            ]
        ],
        [
            'text' => 'Organizations',
            'icon'        => 'sitemap',
            'icon_color'  => 'orange',
            'submenu'     => [
                [
                    'text'  => 'Companies',
                    'url'   => 'companies',
                    'icon_color'  => 'orange',
                    'icon' => 'university '
                ],
                [
                    'text'  => 'Departments',
                    'url'   => 'departments',
                    'icon_color'  => 'orange',
                ],
                [
                    'text'  => 'Locations',
                    'url'   => 'locations',
                    'icon_color'  => 'orange',
                    'icon' => 'map-marker',
                ],
                [
                    'text'  => 'Employees',
                    'url'   => 'employees',
                    'icon_color'  => 'orange',
                    'icon' => 'male',
                ],
                [
                    'text'  => 'Positions',
                    'url'   => 'positions',
                    'icon_color' => 'orange',
                    'icon'  => 'bullseye',
                ],
                [
                    'text'  => 'Projects',
                    'url'   => 'projects',
                    'icon_color'  => 'orange',
                ],
                [
                    'text'  => 'Cost center',
                    'url'   => '#',
                    'icon_color'  => 'orange',
                ],
                [
                    'text'  => 'Account code',
                    'url'   => '#',
                    'icon_color'  => 'orange',
                ],
                [
                    'text'  => 'Item groups',
                    'url'   => '#',
                    'icon_color'  => 'orange',
                ],
                [
                    'text'  => 'Item code',
                    'url'   => '#',
                    'icon_color'  => 'orange',
                ]
            ]
        ],
        'APP',
        [
            'text' => 'Purchase Request',
            'url'  => '#',
            'icon' => 'shopping-cart',
            'icon_color'  => 'purple',
            'submenu'   => [
                [
                    'text'  => 'draft',
                    'url'   => 'pr/draft',
                    'icon_color'  => 'purple',
                ],
                [
                    'text'  => 'inbox',
                    'url'   => 'pr/inbox'
                ],
                [
                    'text'  => 'outbox',
                    'url'   => 'pr/outbox'
                ]
            ]
        ],
        [
            'text' => 'Inventory',
            'url'  => '#',
            'icon_color'  => 'yellow',
            'icon' => 'calculator',
            'submenu'   => [
                [
                    'text'  => 'Items',
                    'url'   => 'inventory/items'
                ]
            ]
        ],
        'SETTING',
        [
            'text'       => 'Change Password',
            'icon_color' => 'red',
        ],
        [
            'text'       => 'Log out',
            'icon_color' => 'yellow',
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
