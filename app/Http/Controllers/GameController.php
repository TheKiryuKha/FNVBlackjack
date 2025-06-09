<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\DeleteGame;
use App\Actions\EditGame;
use App\Actions\StartGame;
use App\Enums\GameStatus;
use App\Http\Requests\GameRequest;
use App\Models\Game;
use App\Models\User;
use App\Policies\GamePolicy;
use Illuminate\Http\JsonResponse;
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

    public function show(Game $game, GamePolicy $policy): View
    {
        /** @var User $user */
        $user = $game->user;

        /** @var \App\Models\Croupier $croupier */
        $croupier = $game->croupier;

        return view('game.show', [
            'game' => $game,
            'users_cards' => $user->cards,
            'croupiers_cards' => $croupier->cards,
            'isCroupiersMove' => $policy->isCroupierMove($game),
            'isUserHasMoreChips' => $policy->isUserHasMoreChips($user),
            'isGameOver' => $policy->isGameOver($game),
        ]);
    }

    public function update(Game $game, EditGame $action): JsonResponse
    {
        $action->handle($game);

        return response()->json([
            'status' => 200,
        ]);
    }

    public function croupiersMove(Game $game): JsonResponse
    {
        $game->update([
            'status' => GameStatus::CroupiersMove
        ]);

        return response()->json([
            'status' => 200,
        ]);
    }

    public function destroy(Game $game, DeleteGame $action): JsonResponse
    {
        $action->handle($game);

        return response()->json([
            'status' => 200,
        ]);
    }
}
