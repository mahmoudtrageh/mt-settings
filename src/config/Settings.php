<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Settings Route Configuration
    |--------------------------------------------------------------------------
    |
    | Configure the route prefix and middleware for settings management
    |
    */

    'route_prefix' => 'admin',
    'middleware' => ['web', 'auth'],
    'route_name' => 'settings',

    /*
    |--------------------------------------------------------------------------
    | Settings Cache Configuration
    |--------------------------------------------------------------------------
    |
    | Configure settings cache behavior
    |
    */
    
    'cache_key' => 'settings.all',
    'cache_ttl' => 86400, // 24 hours in seconds
    
    /*
    |--------------------------------------------------------------------------
    | Settings UI Configuration
    |--------------------------------------------------------------------------
    |
    | Configure the settings UI appearance
    |
    */

    'ui' => [
        'extend_layout' => 'admin.layouts.app', // The main layout the settings view extends
        'title' => 'إعدادات النظام',            // Default page title
        'direction' => 'rtl',                   // Text direction (rtl or ltr)
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Error and Success Messages
    |--------------------------------------------------------------------------
    |
    | Define messages displayed to users
    |
    */
   
    'messages' => [
        'settings_updated' => 'تم حفظ الإعدادات بنجاح.',
        'cache_cleared' => 'تم مسح ذاكرة التخزين المؤقت بنجاح.',
        'unknown_section' => 'قسم غير معروف.',
    ],
];