<?php

declare(strict_types=1);

use App\Modules\State\Http\Controllers\StateController;

Route::get('/', [StateController::class, 'getStatesActive']);
