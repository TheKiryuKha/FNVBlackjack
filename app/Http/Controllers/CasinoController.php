<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\View\View;

final class CasinoController
{
    public function index(): View
    {
        $cards = [
            [
                'suit' => 'бубы',
                'type' => '10',
                'points' => 10,
            ],

            [
                'suit' => 'черви',
                'type' => '1',
                'points' => 1,
            ],

            [
                'suit' => 'пики',
                'type' => '2',
                'points' => 2,
            ],

            [
                'suit' => 'пики',
                'type' => 'короли',
                'points' => 10,
            ],
        ];

        return view('welcome', [
            'cards' => $cards,
        ]);
    }
}
