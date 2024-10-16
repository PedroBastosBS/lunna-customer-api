<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Modules\User\Adapters\Providers\RouteServiceProvider::class,
    App\Modules\State\Adapters\Providers\RouteServiceProvider::class,
    App\Modules\City\Adapters\Providers\RouteServiceProvider::class,
    App\Modules\Auth\Adapters\Providers\RouteServiceProvider::class,
    App\Modules\User\Adapters\Providers\UserServiceProvider::class
];
