<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\CreateCard;
use App\Actions\StartGame;
use App\Enums\GameStatus;
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
        $bet = (int) $request->validated()['bet'];

        /** @var User $user */
        $user = auth()->user();

        $game = $action->handle($user, $bet);

        return redirect(route('game', $game));
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

    public function croupierMove(): Response
    {
        return response(status: 200);
    }

    public function loose(Game $game): RedirectResponse
    {
        $user = $game->user;

        $user->chips = $user->chips - $game->bet;
        $user->chipsWon = $user->chipsWon - $game->bet;
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
