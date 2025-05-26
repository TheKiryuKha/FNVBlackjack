<?php

declare(strict_types=1);

namespace App\Enums;

enum CardFace: string
{
    case King = 'king';
    case Queen = 'queen';
    case Jack = 'jack';
    case Ace = 'ace';
}
