<?php

namespace App\Modules\City\Adapters\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

final class RouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'App\Modules\City\Presentations\Http\Controllers';

    public function register()
    {
    }

    public function boot()
    {
        $this->map();
    }

    protected function map()
    {
        Route::prefix('api/cities')
            ->namespace($this->namespace)
            ->group(__DIR__.'/../routes/api.php');
    }
}
