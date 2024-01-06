<?php

declare(strict_types=1);

namespace Inspira\Console\Output;

/**
 * Class FgColor
 *
 * Represents foreground color settings for console output using ANSI escape codes.
 *
 * @package Inspira\Console\Output
 */
class FgColor extends Color
{
	/**
	 * ANSI fg color prefix for normal color mode
	 */
	protected const NORMAL = 3;

	/**
	 * ANSI fg color prefix for bright color mode
	 */
	protected const BRIGHT = 9;
}
