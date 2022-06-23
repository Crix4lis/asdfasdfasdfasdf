<?php

namespace App\Enum;

enum GameState: string
{
    case WIN = 'WIN';
    case LOST = 'LOST';
    case RUNNING = 'RUNNING';
}
