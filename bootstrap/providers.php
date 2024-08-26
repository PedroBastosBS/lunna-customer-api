<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Modules\User\Adapters\Providers\RouteServiceProvider::class,
    App\Modules\Auth\Adapters\Providers\RouteServiceProvider::class,
    App\Modules\User\Adapters\Providers\UserServiceProvider::class
];
