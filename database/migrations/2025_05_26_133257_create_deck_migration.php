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

        foreach (CardSuit::cases() as $suit) {
            for ($i = 2; $i <= 10; $i++) {
                DB::table('deck')->insert([
                    'type' => $i,
                    'suit' => $suit,
                    'points' => $i,
                ]);
            }

            foreach (CardFace::cases() as $face) {
                DB::table('deck')->insert([
                    'type' => $face,
                    'suit' => $suit,
                    'points' => 10,
                ]);
            }

        }
    }
};
