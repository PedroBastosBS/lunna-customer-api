<?php

namespace App\Providers;

use App\Models\Broker;
use App\Observers\BrokersS3IntegrationObeserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Broker::observe(BrokersS3IntegrationObeserver::class);
    }
}
