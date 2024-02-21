<?php

declare(strict_types=1);

namespace Inspira\Console\Styles;

use Inspira\Console\Contracts\ColorInterface;
use Inspira\Console\Enums\Color as ColorEnum;
use InvalidArgumentException;

/**
 * Class Color
 *
 * Abstract class representing color settings for console output using ANSI escape codes.
 * This class and it's implementing class cannot be use independently as its method only
 * returns the color sequence and not the entire style sequence. Use this with Styles class.
 *
 * @package Inspira\Console\Styles
 */
abstract class Color implements ColorInterface
{
	/**
	 * Custom color type constant.
	 */
	protected const CUSTOM = 8;

	/**
	 * Palette color type constant.
	 */
	protected const PALETTE = 5;

	/**
	 * RGB color type constant.
	 */
	protected const RGB = 2;

	/**
	 * Separator for ANSI escape code parameters.
	 */
	protected const SEPARATOR = ';';

	/**
	 * Get the ANSI escape code for the specified color with brightness setting.
	 *
	 * @param ColorEnum $color  The color enumeration.
	 * @param bool $isBright Whether to use the bright color.
	 * @return string  The ANSI escape code for the specified color.
	 */
	public function color(ColorEnum $color, bool $isBright = false): string
	{
		$brightness = $isBright ? static::BRIGHT : static::NORMAL;

		return $brightness . $color->value;
	}

	/**
	 * Get the ANSI escape code for a custom color from the palette.
	 *
	 * @param int $color The color code between 0 - 255.
	 * @return string The ANSI escape code for the specified custom color.
	 * @throws InvalidArgumentException If an invalid color code is provided.
	 */
	public function palette(int $color): string
	{
		if ($color < 0 || $color > 255) {
			throw new InvalidArgumentException("Invalid color code, only between 0 - 255 is accepted.");
		}

		return implode(self::SEPARATOR, [
			static::NORMAL . self::CUSTOM,
			self::PALETTE,
			$color
		]);
	}

	/**
	 * Get the ANSI escape code for an RGB color.
	 *
	 * @param int $red Red component (between 0 - 255).
	 * @param int $green Green component (between 0 - 255).
	 * @param int $blue Blue component (between 0 - 255).
	 * @return string The ANSI escape code for the specified RGB color.
	 * @throws InvalidArgumentException If an invalid color code is provided.
	 */
	public function rgb(int $red, int $green, int $blue): string
	{
		if (
			$red < 0 || $red > 255 ||
			$green < 0 || $green > 255 ||
			$blue < 0 || $blue > 255
		) {
			throw new InvalidArgumentException("Invalid color code, only between 0 - 255 is accepted.");
		}

		return implode(self::SEPARATOR, [
			static::NORMAL . self::CUSTOM,
			self::RGB,
			$red,
			$green,
			$blue
		]);
	}
}
