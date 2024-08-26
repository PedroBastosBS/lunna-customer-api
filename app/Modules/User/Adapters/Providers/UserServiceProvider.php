<?php

namespace App\Modules\User\Adapters\Providers;

use App\Modules\User\Services\CompleteRegistrationService;
use App\Modules\User\UseCases\CompleteRegistrationUseCase;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(CompleteRegistrationUseCase::class, CompleteRegistrationService::class);
    }
}