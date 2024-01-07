<?php

declare(strict_types=1);

namespace Inspira\Console\Styles;

/**
 * Class FgColor
 *
 * Represents foreground color settings for console output using ANSI escape codes.
 * This class cannot be use independently as its method only returns the color sequence
 * and not the entire style sequence. Use this with Styles class
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
