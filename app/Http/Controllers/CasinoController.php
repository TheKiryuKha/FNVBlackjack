<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\GameStatus;
use App\Models\Card;
use App\Models\Croupier;
use App\Models\Game;
use DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

final class CasinoController
{
    public function index(): View
    {
        return view('welcome');
    }

    public function startGame(): RedirectResponse
    {
        $attr = request()->validate([
            'bet' => ['required', 'integer', 'min:1', 'max:200']
        ]);

        $croupier = Croupier::inRandomOrder()->firstOrFail();

        $game = Game::create([
            'user_id' => auth()->user()->id,
            'croupier_id' => $croupier->id,
            'bet' => $attr['bet'],
            'status' => GameStatus::PlayersMove->value
        ]);

        for($i=1; $i <=2; $i++){
            $card = DB::table('deck')->inRandomOrder()->firstOrFail();
            
            Card::create([
                'game_id' => $game->id,
                'owner_id' => auth()->user()->id,
                'owner_type' => 'user',
                'type' => $card->type,
                'suit' => $card->suit,
                'points' => $card->points,
            ]);
        }

        $card = DB::table('deck')->inRandomOrder()->firstOrFail();

        Card::create([
            'game_id' => $game->id,
            'owner_id' => $croupier->id,
            'owner_type' => 'croupier',
            'type' => $card->type,
            'suit' => $card->suit,
            'points' => $card->points,
        ]);

        return redirect(route('game'));
    }

    public function game()
    {
        return response(status: 200);
    }
}
