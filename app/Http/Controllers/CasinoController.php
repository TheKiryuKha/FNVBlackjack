<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\CreateCard;
use App\Actions\DeleteGame;
use App\Actions\StartGame;
use App\Enums\GameStatus;
use App\Http\Requests\GameRequest;
use App\Models\Game;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

final class CasinoController
{
    public function index(): View
    {
        return view('welcome');
    }

    public function startGame(GameRequest $request, StartGame $action): RedirectResponse
    {
        /** @var int $bet */
        $bet = (int) $request->validated()['bet'];

        /** @var User $user */
        $user = auth()->user();

        $game = $action->handle($user, $bet);

        return to_route('game', $game);
    }

    public function game(Game $game): RedirectResponse|View
    {
        // auth
        if ($game->user->getPoints() === 21) {
            return to_route('win', $game);
        }

        if ($game->user->getPoints() > 21) {
            return to_route('loose', $game);
        }

        if ($game->status === GameStatus::CroupiersMove) {
            return to_route('');
        }

        $user_cards = $game->user->cards;
        $croupiers_cards = $game->croupier->cards;

        return view('game', [
            'game' => $game,
            'users_cards' => $user_cards,
            'croupiers_cards' => $croupiers_cards,
        ]);
    }

    public function getCard(Game $game, CreateCard $action): RedirectResponse
    {
        $action->handle([
            'game_id' => $game->id,
            'owner_id' => $game->user->id,
            'owner_type' => 'user',
        ]);

        return to_route('game', $game);
    }

    public function doubleBet(Game $game): RedirectResponse
    {
        $game->bet = $game->bet * 2;
        $game->status = GameStatus::CroupiersMove;
        $game->save();

        return to_route('game', $game);
    }

    public function endGame(Game $game, DeleteGame $action): RedirectResponse
    {
        $action->handle($game);

        return to_route('home');
    }
}
