<?php

declare(strict_types=1);

use App\Http\Controllers\GameController;
use Illuminate\Support\Facades\Route;

Route::get('/', [GameController::class, 'create'])
    ->middleware('auth')
    ->name('games.create');

Route::post('/', [GameController::class, 'store'])
    ->middleware('auth')
    ->name('games.store');

Route::get('/game/{game}', [GameController::class, 'show'])
    ->middleware('auth')
    ->name('games.show');

Route::patch('/game/{game}', [GameController::class, 'update'])
    ->middleware('auth')
    ->name('games.update');

Route::delete('/game/{game}', [GameController::class, 'destroy'])
    ->middleware('auth')
    ->name('games.destroy');


// Уберу это на CardContrller
Route::post('/game/{game}', [GameController::class, 'getCard'])
    ->middleware('auth')
    ->name('getCard');
// 