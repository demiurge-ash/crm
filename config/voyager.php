<?php

return [
    /*
    |--------------------------------------------------------------------------
    | User config
    |--------------------------------------------------------------------------
    |
    | Here you can specify voyager user configs
    |
    */

    'user' => [
        'add_default_role_on_register' => true,
        'default_role'                 => 'user',
        // Set `namespace` to `null` to use `config('auth.providers.users.model')` value
        // Set `namespace` to a class to override auth user model.
        // However make sure the appointed class must ready to use before installing voyager.
        // Otherwise `php artisan voyager:install` will fail with class not found error.
        'namespace'                    => null,
        'default_avatar'               => 'users/default.png',
        'redirect'                     => '/admin',
    ],

    /*
    |--------------------------------------------------------------------------
    | Controllers config
    |--------------------------------------------------------------------------
    |
    | Here you can specify voyager controller settings
    |
    */

    'controllers' => [
        'namespace' => 'TCG\\Voyager\\Http\\Controllers',
    ],

    /*
    |--------------------------------------------------------------------------
    | Models config
    |--------------------------------------------------------------------------
    |
    | Here you can specify default model namespace when creating BREAD.
    | Must include trailing backslashes. If not defined the default application
    | namespace will be used.
    |
    */

    'models' => [
        //'namespace' => 'App\\',
    ],

    /*
    |--------------------------------------------------------------------------
    | Path to the Voyager Assets
    |--------------------------------------------------------------------------
    |
    | Here you can specify the location of the voyager assets path
    |
    */

    'assets_path' => '/vendor/tcg/voyager/assets',

    /*
    |--------------------------------------------------------------------------
    | Storage Config
    |--------------------------------------------------------------------------
    |
    | Here you can specify attributes related to your application file system
    |
    */

    'storage' => [
        'disk' => 'public',
    ],

    /*
    |--------------------------------------------------------------------------
    | Media Manager
    |--------------------------------------------------------------------------
    |
    | Here you can specify if media manager can show hidden files like(.gitignore)
    |
    */

    'hidden_files' => false,

    /*
    |--------------------------------------------------------------------------
    | Database Config
    |--------------------------------------------------------------------------
    |
    | Here you can specify voyager database settings
    |
    */

    'database' => [
        'tables' => [
            'hidden' => ['migrations', 'data_rows', 'data_types', 'menu_items', 'password_resets', 'permission_role', 'settings'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Multilingual configuration
    |--------------------------------------------------------------------------
    |
    | Here you can specify if you want Voyager to ship with support for
    | multilingual and what locales are enabled.
    |
    */

    'multilingual' => [
        /*
         * Set whether or not the multilingual is supported by the BREAD input.
         */
        'enabled' => false,

        /*
         * Set whether or not the admin layout default is RTL.
         */
        'rtl' => false,

        /*
         * Select default language
         */
        'default' => 'ru',

        /*
         * Select languages that are supported.
         */
        'locales' => [
            'ru',
            //'pt',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Dashboard config
    |--------------------------------------------------------------------------
    |
    | Here you can modify some aspects of your dashboard
    |
    */

    'dashboard' => [
        // Add custom list items to navbar's dropdown
        'navbar_items' => [
            'Profile' => [
                'route'      => 'voyager.profile',
                'classes'    => 'class-full-of-rum',
                'icon_class' => 'voyager-person',
            ],
            'Home' => [
                'route'        => '/',
                'icon_class'   => 'voyager-home',
                'target_blank' => true,
            ],
            'Logout' => [
                'route'      => 'voyager.logout',
                'icon_class' => 'voyager-power',
            ],
        ],

        'widgets' => [
            'App\\Widgets\\UserWidget',
            'App\\Widgets\\ClientWidget',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Automatic Procedures
    |--------------------------------------------------------------------------
    |
    | When a change happens on Voyager, we can automate some routines.
    |
    */

    'bread' => [
        // When a BREAD is added, create the Menu item using the BREAD properties.
        'add_menu_item' => true,

        // which menu add item to
        'default_menu' => 'admin',

        // When a BREAD is added, create the related Permission.
        'add_permission' => true,

        // which role add premissions to
        'default_role' => 'admin',
    ],

    /*
    |--------------------------------------------------------------------------
    | UI Generic Config
    |--------------------------------------------------------------------------
    |
    | Here you change some of the Voyager UI settings.
    |
    */

    'primary_color' => '#156a7c',

    'show_dev_tips' => true, // Show development tip "How To Use:" in Menu and Settings

    // Here you can specify additional assets you would like to be included in the master.blade
    'additional_css' => [
        'css/admin/admin.css',
        'css/admin/fontawesome.css',
    ],

    'additional_js' => [
        'js/admin/admin.js',
        'js/admin/fontawesome.js',
    ],

    'googlemaps' => [
         'key'    => env('GOOGLE_MAPS_KEY', ''),
         'center' => [
             'lat' => env('GOOGLE_MAPS_DEFAULT_CENTER_LAT', '32.715738'),
             'lng' => env('GOOGLE_MAPS_DEFAULT_CENTER_LNG', '-117.161084'),
         ],
         'zoom' => env('GOOGLE_MAPS_DEFAULT_ZOOM', 11),
     ],

];
