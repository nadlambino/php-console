<?php

declare(strict_types=1);

namespace Inspira\Console\Enums;

/**
 * Enum Color
 *
 * Represents color options for console output using ANSI escape codes.
 *
 * @package Inspira\Console\Enums
 */
enum Color: int
{
	case BLACK = 0;
	case RED = 1;
	case GREEN = 2;
	case YELLOW = 3;
	case BLUE = 4;
	case MAGENTA = 5;
	case CYAN = 6;
	case WHITE = 7;
	case DEFAULT = 9;
}
