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
        ->can('isUser', 'game')
        ->name('games.show');

    Route::patch('/game/{game}', 'update')
        ->can('isUser', 'game')
        ->name('games.update');

    Route::delete('/game/{game}', 'destroy')
        ->can('isUser', 'game')
        ->name('games.destroy');
});
