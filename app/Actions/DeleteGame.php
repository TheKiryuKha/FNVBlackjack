<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Game;
use DB;

final class DeleteGame
{
    public function __construct(
        private WinUser $winAction,
        private LooseUser $looseAction
    ) {}

    public function handle(Game $game): void
    {
        DB::transaction(function () use ($game) {

            if ($game->user->getPoints() > 21) {
                $this->looseAction->handle($game->user, $game->bet);
            }

            if ($game->croupier->getPoints() > 21) {
                $this->winAction->handle($game->user, $game->bet);
            }

            if ($game->user->getPoints() > $game->croupier->getPoints()) {
                $this->winAction->handle($game->user, $game->bet);
            }

            if ($game->user->getPoints() < $game->croupier->getPoints()) {
                $this->looseAction->handle($game->user, $game->bet);
            }

            $game->user->cards->each(function ($card) {
                $card->delete();
            });
            $game->croupier->cards->each(function ($card) {
                $card->delete();
            });

            $game->delete();
        });
    }
}
