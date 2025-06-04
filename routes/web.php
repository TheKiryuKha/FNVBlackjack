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

Route::get('/game/{game}/endGame', [CasinoController::class, 'endGame'])
    ->middleware('auth')
    ->name('endGame');

Route::post('/game/{game}', [CasinoController::class, 'getCard'])
    ->middleware('auth')
    ->name('getCard');

Route::post('/game/{game}/db', [CasinoController::class, 'doubleBet'])
    ->middleware('auth')
    ->name('doubleBet');

Route::patch('/game/{game}', [CasinoController::class, 'stopMove'])
    ->middleware('auth')
    ->name('stopMove');

Route::post('/game/{game}/sdfsdfdsf', [CasinoController::class, 'croupiersMove'])
    ->middleware('auth')
    ->name('croupiersMove');
