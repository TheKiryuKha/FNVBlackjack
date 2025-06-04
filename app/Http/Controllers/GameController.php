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
use App\Policies\GamePolicy;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use function GuzzleHttp\default_ca_bundle;

final class GameController
{
    public function create(): View
    {
        return view('game.create');
    }

    public function store(GameRequest $request, StartGame $action): RedirectResponse
    {
        /** @var int $bet */
        $bet = (int) $request->validated()['bet'];

        /** @var User $user */
        $user = auth()->user();

        $game = $action->handle($user, $bet);

        return to_route('games.show', $game);
    }

    public function show(Game $game, GamePolicy $policy): RedirectResponse|View
    {
        return match(true){
            $policy->isCroupierMove($game) => to_route(''),
            $policy->isGameOver($game->user) => to_route('games.destory'),
            default => view('games.show', [
                'game' => $game,
                'users_cards' => $game->user->cards,
                'croupiers_cards' => $game->croupier->cards,
            ])
        };
    }

    /**
     * вынести это в CardController
     */
    public function getCard(Game $game, CreateCard $action): RedirectResponse
    {
        $action->handle([
            'game_id' => $game->id,
            'owner_id' => $game->user->id,
            'owner_type' => 'user',
        ]);

        return to_route('games.show', $game);
    }

    public function update(Game $game): RedirectResponse
    {
        $game->bet = $game->bet * 2;
        $game->status = GameStatus::CroupiersMove;
        $game->save();

        return to_route('games.show', $game);
    }

    public function destroy(Game $game, DeleteGame $action): RedirectResponse
    {
        $action->handle($game);

        return to_route('games.create');
    }
}
