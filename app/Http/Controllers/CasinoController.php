<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\StartGame;
use App\Http\Requests\GameRequest;
use App\Models\Game;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
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
        $bet = $request->validated()['bet'];

        /** @var User $user */
        $user = auth()->user();

        $action->handle($user, $bet);

        return redirect(route('game'));
    }

    public function game(): Response
    {

        return response(status: 200);
    }

    public function loose()
    {
        // отнимает ставки
        // удалят все карты игры
    }

    public function win(Game $game): RedirectResponse
    {
        $user = $game->user;
        $user->chips = $user->chips + $game->bet;
        $user->chipsWon = $user->chipsWon + $game->bet;
        $user->save();

        $user->cards->each(function ($card) {
            $card->delete();
        });
        $game->croupier->cards->each(function ($card) {
            $card->delete();
        });

        $game->delete();

        return to_route('home');
    }
}
