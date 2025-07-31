<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Twill Auth configuration
    |--------------------------------------------------------------------------
    */

    'auth_guard' => 'twill_users',

'auth_login_url' => 'admin/login',

'auth_login_redirect_path' => 'admin',

'route_group_middleware' => ['web', 'twill.auth'],


];
