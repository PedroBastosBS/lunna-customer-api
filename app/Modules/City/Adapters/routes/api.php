<?php

declare(strict_types=1);

use App\Modules\City\Http\Controllers\CityController;

Route::get('/{stateId}', [CityController::class, 'getCitiesByState']);
