<?php

declare(strict_types=1);

namespace App\Actions;

use App\Enums\GameStatus;
use App\Models\Croupier;
use App\Models\Game;
use App\Models\User;
use DB;

final class StartGame
{
    public function __construct(
        private CreateCard $createCard
    ) {}

    public function handle(User $user, int $bet): Game
    {
        return DB::transaction(function () use ($user, $bet) {
            $croupier = Croupier::getRandomCroupier();

            $game = $this->createGame($user, $croupier, $bet);
            $this->createCards($game, $user, $croupier);

            return $game;
        });
    }

    private function createGame(User $user, Croupier $croupier, int $bet): Game
    {
        return Game::create([
            'user_id' => $user->id,
            'croupier_id' => $croupier->id,
            'bet' => $bet,
            'status' => GameStatus::PlayersMove,
        ]);
    }

    private function createCards(Game $game, User $user, Croupier $croupier): void
    {
        for ($i = 0; $i < 2; $i++) {
            $this->createCard->handle($game, $user);
        }

        $this->createCard->handle($game, $croupier);
    }
}
