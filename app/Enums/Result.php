<?php

namespace App\Enums;

enum Result: string
{
	case WIN = 'win';
	case LOSS = 'loss';
	case TIE = 'tie';
}
