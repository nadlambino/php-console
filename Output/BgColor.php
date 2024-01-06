<?php

declare(strict_types=1);

namespace Inspira\Console\Output;

/**
 * Class BgColor
 *
 * Represents background color settings for console output using ANSI escape codes.
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
