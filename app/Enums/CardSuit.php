<?php

declare(strict_types=1);

namespace App\Enums;

enum CardSuit: string
{
    case Diamonds = 'diamonds';
    case Hearts = 'hearts';
    case Clubs = 'clubs';
    case Spades = 'spades';
}
