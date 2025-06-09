<?php

declare(strict_types=1);

namespace App\Actions;

use App\Enums\GameStatus;
use App\Models\Croupier;
use App\Models\Game;
use DB;

final class GetCardsForCroupier
{
    public function __construct(
        private CreateCard $action,
    ) {}

    public function handle(Croupier $croupier): void
    {
        DB::transaction(function () use ($croupier) {
            /** @var Game $game */
            $game = $croupier->game;

            $this->action->handle($game, $croupier);

            if ($croupier->refresh()->getPoints() >= 17) {
                $game->update([
                    'status' => GameStatus::GameOver,
                ]);
            }
        });
    }
}
