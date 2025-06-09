<?php

declare(strict_types=1);

use App\Enums\CardFace;
use App\Enums\CardSuit;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('deck', function (Blueprint $table) {
            $table->id();

            $table->string('type');

            $table->string('suit');

            $table->unsignedInteger('points');

            $table->timestamps();
        });

        $cards = array_map(fn (CardFace $case) => $case->value, CardFace::cases());
        $faces = [
            CardFace::King->value,
            CardFace::Queen->value,
            CardFace::Ace->value,
            CardFace::Jack->value,
        ];

        foreach (CardSuit::cases() as $suit) {

            $i = 2;
            foreach (array_diff($cards, $faces) as $card) {
                DB::table('deck')->insert([
                    'type' => $card,
                    'suit' => $suit->value,
                    'points' => $i,
                ]);
                $i++;
            }

            foreach ($faces as $face) {
                DB::table('deck')->insert([
                    'type' => $face,
                    'suit' => $suit->value,
                    'points' => 10,
                ]);
            }

        }
    }
};
