<?php

declare(strict_types=1);

use App\Modules\User\Http\Controllers\UserController;

Route::post('/', [UserController::class, 'save']);
Route::post('/reset-password', [UserController::class, 'resetPasswordNotification']);
Route::post('/reset', [UserController::class, 'passwordReset']);

Route::get('/top-brokers', [UserController::class, 'showTopAdvertisers']);
Route::middleware(['auth:api'])->group(function () {
    Route::post('/finalization/{id}', [UserController::class, 'completeRegistration']);
    Route::put('rating/{userId}', [UserController::class, 'ratingUpdate']);
    Route::get('{id}', [UserController::class, 'findUserById']);
});

Route::get('/advertisers/{userId}', [UserController::class, 'findAdvertisersByProperty']);
