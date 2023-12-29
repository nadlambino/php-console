<?php

declare(strict_types=1);

namespace Inspira\Console;

enum Colors: string
{
	case BASE = "\033[0m";
	case GREEN = "\033[1;32m";
	case BLUE = "\033[94m";
	case YELLOW = "\033[33m";
	case RED = "\033[0;31m";
}
