<?php

declare(strict_types=1);

use App\Modules\User\Http\Controllers\UserController;

Route::post('/', [UserController::class, 'save']);