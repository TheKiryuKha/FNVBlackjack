<?php

declare(strict_types=1);

use App\Models\Card;
use App\Models\Croupier;
use App\Models\Game;
use App\Models\User;

test('user wins game', function () {
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

    $response = $this->actingAs($user)
        ->from(route('game', $game))
        ->get(route('endGame', $game));

    $response->assertRedirectToRoute('home');

    expect($user->fresh())
        ->chips->toBe(400)
        ->chipsWon->toBe(200);

    expect(Game::count())->toBe(0);
    expect(Card::count())->toBe(0);
});

test('user looses game', function () {
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

    $response = $this->actingAs($user)
        ->from(route('game', $game))
        ->get(route('endGame', $game));

    $response->assertRedirectToRoute('home');

    expect($user->fresh())
        ->chips->toBe(0)
        ->chipsWon->toBe(-200);

    expect(Game::count())->toBe(0);
    expect(Card::count())->toBe(0);
});
