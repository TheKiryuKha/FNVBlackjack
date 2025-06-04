<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\DeleteGame;
use App\Actions\EditGame;
use App\Actions\StartGame;
use App\Http\Requests\GameRequest;
use App\Models\Game;
use App\Models\User;
use App\Policies\GamePolicy;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

final class GameController
{
    public function create(): View
    {
        return view('game.create');
    }

    public function store(GameRequest $request, StartGame $action): RedirectResponse
    {
        /** @var User $user */
        $user = auth()->user();

        /** @var int $bet */
        $bet = $request->validated()['bet'];

        $game = $action->handle($user, $bet);

        return to_route('games.show', $game);
    }

    public function show(Game $game, GamePolicy $policy): RedirectResponse|View
    {
        /** @var User $user */
        $user = $game->user;

        /** @var \App\Models\Croupier $croupier */
        $croupier = $game->croupier;

        return match (true) {
            $policy->isCroupierMove($game) => to_route('croupier'),
            $policy->isGameOver($user) => to_route('games.destroy', $game),
            default => view('game.show', [
                'game' => $game,
                'users_cards' => $user->cards,
                'croupiers_cards' => $croupier->cards,
            ])
        };
    }

    public function update(Game $game, EditGame $action): RedirectResponse
    {
        $action->handle($game);

        return to_route('games.show', $game);
    }

    public function destroy(Game $game, DeleteGame $action): RedirectResponse
    {
        $action->handle($game);

        return to_route('games.create');
    }
}
