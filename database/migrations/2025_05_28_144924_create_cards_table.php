<?php

declare(strict_types=1);

use App\Models\Game;
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
        Schema::create('cards', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Game::class)
                ->constrained();

            $table->unsignedBigInteger('owner_id');
            $table->string('owner_type');

            $table->string('type');

            $table->string('suit');

            $table->unsignedInteger('points');

            $table->timestamps();
        });
    }
};
