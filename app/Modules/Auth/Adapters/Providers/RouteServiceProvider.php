<?php

namespace App\Modules\Auth\Adapters\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

final class RouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'App\Modules\Auth\Http\Controllers';

    public function register()
    {
    }

    public function boot()
    {
        $this->map();
    }

    protected function map()
    {
        Route::prefix('/auth')
            ->namespace($this->namespace)
            ->group(__DIR__.'/../routes/api.php');
    }
}
