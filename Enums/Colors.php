<?php

declare(strict_types=1);

namespace Inspira\Console\Enums;

/**
 * Class Colors
 *
 * Enumerates ANSI color codes for console output.
 *
 * @package Inspira\Console\Enums
 */
enum Colors: string
{
	/**
	 * Reset text formatting.
	 */
	case BASE = "\033[0m";

	/**
	 * Green text color.
	 */
	case GREEN = "\033[1;32m";

	/**
	 * Blue text color.
	 */
	case BLUE = "\033[94m";

	/**
	 * Yellow text color.
	 */
	case YELLOW = "\033[33m";

	/**
	 * Red text color.
	 */
	case RED = "\033[0;31m";
}
