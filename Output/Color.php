<?php

declare(strict_types=1);

namespace Inspira\Console\Output;

use Inspira\Console\Enums\Color as ColorEnum;

/**
 * Class Color
 *
 * Abstract class representing color settings for console output using ANSI escape codes.
 *
 * @package Inspira\Console\Output
 */
abstract class Color
{
	/**
	 * @var bool Whether to use bright or normal color mode
	 */
	protected bool $isBright = false;

	/**
	 * Enable the bright version of the color.
	 *
	 * @return static
	 */
	public function bright(): static
	{
		$this->isBright = true;

		return $this;
	}

	/**
	 * Get the ANSI escape code for the specified color with brightness setting.
	 *
	 * @param ColorEnum $color  The color enumeration.
	 *
	 * @return string  The ANSI escape code for the specified color.
	 */
	public function color(ColorEnum $color): string
	{
		$brightness = $this->isBright ? static::BRIGHT : static::NORMAL;

		return $brightness . $color->value;
	}

	/**
	 * Reset the brightness setting to normal.
	 *
	 * @return static
	 */
	public function reset(): static
	{
		$this->isBright = false;

		return $this;
	}
}
