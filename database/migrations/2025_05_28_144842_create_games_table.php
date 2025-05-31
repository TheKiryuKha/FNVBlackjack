<?php

declare(strict_types=1);

use App\Models\Croupier;
use App\Models\User;
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
        Schema::create('games', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(User::class)
                ->constrained();

            $table->foreignIdFor(Croupier::class)
                ->constrained();

            $table->integer('bet');
            $table->string('status');
            $table->timestamps();
        });
    }
};
