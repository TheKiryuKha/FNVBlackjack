<?php

declare(strict_types=1);

use App\Http\Controllers\CasinoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CasinoController::class, 'index'])
    ->middleware('auth')
    ->name('home');

Route::post('/', [CasinoController::class, 'startGame'])
    ->middleware('auth')
    ->name('startGame');

Route::get('/game/{game}', [CasinoController::class, 'game'])
    ->middleware('auth')
    ->name('game');

Route::delete('/game/{game}/loose', [CasinoController::class, 'loose'])
    ->middleware('auth')
    ->name('loose');

Route::delete('/game/{game}/win', [CasinoController::class, 'win'])
    ->middleware('auth')
    ->name('win');

Route::post('/game/{game}', [CasinoController::class, 'getCard'])
    ->middleware('auth')
    ->name('getCard');
