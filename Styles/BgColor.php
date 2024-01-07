<?php

declare(strict_types=1);

namespace Inspira\Console\Styles;

/**
 * Class BgColor
 *
 * Represents background color settings for console output using ANSI escape codes.
 * This class cannot be use independently as its method only returns the color sequence
 * and not the entire style sequence. Use this with Styles class.
 *
 * @package Inspira\Console\Output
 */
class BgColor extends Color
{
	/**
	 * ANSI bg color prefix for normal color mode
	 */
	protected const NORMAL = 4;

	/**
	 * ANSI bg color prefix for bright color mode
	 */
	protected const BRIGHT = 10;
}
