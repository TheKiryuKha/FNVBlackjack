<?php

declare(strict_types=1);

use App\Http\Controllers\GameController;
use App\Models\Game;
use Illuminate\Support\Facades\Route;

Route::controller(GameController::class)->middleware('auth')->group(function () {
    Route::get('/', 'create')
        ->can('create', Game::class)
        ->name('games.create');

    Route::post('/', 'store')
        ->can('create', Game::class)
        ->name('games.store');

    Route::get('/game/{game}', 'show')
        ->can('show', 'game')
        ->name('games.show');

    Route::patch('/game/{game}', 'update')
        ->can('update', 'game')
        ->name('games.update');

    Route::delete('/game/{game}', 'destroy')
        ->can('destroy', 'game')
        ->name('games.destroy');
});

// Уберу это на CardContrller
Route::post('/game/{game}', [GameController::class, 'getCard'])
    ->middleware('auth')
    ->name('getCard');
//
