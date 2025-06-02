<?php

declare(strict_types=1);

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
        Schema::create('croupiers', function (Blueprint $table) {
            $table->id();
            $table->string('name');

            $table->timestamps();
        });

        foreach (['Mary', 'Kury', 'Igor', 'Natasha'] as $croupier) {
            DB::table('croupiers')->insert([
                'name' => $croupier,
            ]);
        }
    }
};
