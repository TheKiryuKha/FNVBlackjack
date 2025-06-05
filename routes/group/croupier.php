<?php

declare(strict_types=1);

use App\Http\Controllers\CroupierController;
use Illuminate\Support\Facades\Route;

Route::post('/croupier/{game}', CroupierController::class)
    ->name('croupier');
