<?php

declare(strict_types=1);

use App\Http\Controllers\CardController;
use Illuminate\Support\Facades\Route;

Route::post('/cards/{game}', CardController::class)
    ->middleware('auth')
    ->can('isUser', 'game')
    ->name('cards.store');
