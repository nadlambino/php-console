<?php

declare(strict_types=1);

namespace Inspira\Console\Contracts;

use Inspira\Console\Enums\Color;

/**
 * Interface ColorInterface
 *
 * Interface defining methods for generating ANSI escape codes for console colors.
 */
interface ColorInterface
{
	/**
	 * Get the ANSI escape code for the specified color with brightness setting.
	 *
	 * @param Color $color  The color enumeration.
	 * @param bool $isBright Whether to use the bright color.
	 * @return string  The ANSI escape code for the specified color.
	 */
	public function color(Color $color, bool $isBright): string;

	/**
	 * Get the ANSI escape code for a custom color from the palette.
	 *
	 * @param int $color  The color code between 0 - 255.
	 * @param bool $isBackground Whether it is a background color.
	 * @return string  The ANSI escape code for the specified custom color.
	 */
	public function palette(int $color, bool $isBackground = false): string;

	/**
	 * Get the ANSI escape code for an RGB color.
	 *
	 * @param int $red  Red component (between 0 - 255).
	 * @param int $green  Green component (between 0 - 255).
	 * @param int $blue  Blue component (between 0 - 255).
	 * @param bool $isBackground Whether it is a background color.
	 * @return string  The ANSI escape code for the specified RGB color.
	 */
	public function rgb(int $red, int $green, int $blue, bool $isBackground = false): string;
}
