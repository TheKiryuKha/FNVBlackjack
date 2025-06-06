<?php

declare(strict_types=1);

namespace App\Enums;

enum GameStatus: string
{
    case PlayersMove = 'playersMove';
    case CroupiersMove = 'croupiersMove';
    case GameOver = 'gameOver';
}
