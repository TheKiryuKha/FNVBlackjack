<?php

declare(strict_types=1);

use App\Actions\DeleteGame;
use App\Models\Card;
use App\Models\Croupier;
use App\Models\Game;
use App\Models\User;

it('deletes game and user wins', function () {
    $action = app(DeleteGame::class);
    $user = User::factory()->create(['chips' => 200]);
    $croupier = Croupier::factory()->create();
    $game = Game::factory()->create([
        'user_id' => $user->id,
        'croupier_id' => $croupier->id,
        'bet' => 200,
    ]);
    Card::factory()->count(2)->create([
        'game_id' => $game->id,
        'owner_id' => $user->id,
        'owner_type' => 'user',
        'points' => 10,
    ]);
    Card::factory()->count(2)->create([
        'game_id' => $game->id,
        'owner_id' => $croupier->id,
        'owner_type' => 'croupier',
        'points' => 1,
    ]);

    $action->handle($game);

    expect($user->fresh())
        ->chips->toBe(400)
        ->chipsWon->toBe(200);

    expect(Game::count())->toBe(0);
    expect(Card::count())->toBe(0);
});

it('deletes game and users looses', function () {
    $action = app(DeleteGame::class);
    $user = User::factory()->create(['chips' => 200]);
    $croupier = Croupier::factory()->create();
    $game = Game::factory()->create([
        'user_id' => $user->id,
        'croupier_id' => $croupier->id,
        'bet' => 200,
    ]);
    Card::factory()->count(2)->create([
        'game_id' => $game->id,
        'owner_id' => $user->id,
        'owner_type' => 'user',
        'points' => 1,
    ]);
    Card::factory()->count(2)->create([
        'game_id' => $game->id,
        'owner_id' => $croupier->id,
        'owner_type' => 'croupier',
        'points' => 10,
    ]);

    $action->handle($game);

    expect($user->fresh())
        ->chips->toBe(0)
        ->chipsWon->toBe(-200);

    expect(Game::count())->toBe(0);
    expect(Card::count())->toBe(0);
});

it('deletes game and user has more, than 21 points', function () {
    $action = app(DeleteGame::class);
    $user = User::factory()->create(['chips' => 200]);
    $croupier = Croupier::factory()->create();
    $game = Game::factory()->create([
        'user_id' => $user->id,
        'croupier_id' => $croupier->id,
        'bet' => 200,
    ]);
    Card::factory()->count(3)->create([
        'game_id' => $game->id,
        'owner_id' => $user->id,
        'owner_type' => 'user',
        'points' => 10,
    ]);
    Card::factory()->count(2)->create([
        'game_id' => $game->id,
        'owner_id' => $croupier->id,
        'owner_type' => 'croupier',
        'points' => 1,
    ]);

    $action->handle($game);

    expect($user->fresh())
        ->chips->toBe(0)
        ->chipsWon->toBe(-200);

    expect(Game::count())->toBe(0);
    expect(Card::count())->toBe(0);
});

it('deletes game and croupier has more, than 21 points', function () {
    $action = app(DeleteGame::class);
    $user = User::factory()->create(['chips' => 200]);
    $croupier = Croupier::factory()->create();
    $game = Game::factory()->create([
        'user_id' => $user->id,
        'croupier_id' => $croupier->id,
        'bet' => 200,
    ]);
    Card::factory()->count(2)->create([
        'game_id' => $game->id,
        'owner_id' => $user->id,
        'owner_type' => 'user',
        'points' => 1,
    ]);
    Card::factory()->count(3)->create([
        'game_id' => $game->id,
        'owner_id' => $croupier->id,
        'owner_type' => 'croupier',
        'points' => 10,
    ]);

    $action->handle($game);

    expect($user->fresh())
        ->chips->toBe(400)
        ->chipsWon->toBe(200);

    expect(Game::count())->toBe(0);
    expect(Card::count())->toBe(0);
});
