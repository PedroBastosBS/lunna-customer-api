<?php

declare(strict_types=1);

use App\Modules\User\Http\Controllers\UserController;

Route::post('/', [UserController::class, 'save']);
Route::get('/top-brokers', [UserController::class, 'showTopAdvertisers']);
Route::middleware(['auth:api'])->group(function () {
    Route::put('/finalization/{id}', [UserController::class, 'completeRegistration']);
});
