<?php

declare(strict_types=1);

namespace Inspira\Console\Contracts;

use Inspira\Console\Enums\Color;

/**
 * Interface ColorableInterface
 *
 * Interface providing methods for setting foreground and background colors in a console output.
 * This interface is intended to be implemented by classes that need color customization capabilities.
 */
interface ColorableInterface
{
	/**
	 * Set the foreground color using the specified color and brightness.
	 *
	 * @param Color $color  The foreground color enumeration.
	 * @param bool $isBright Whether to use the bright color.
	 * @return static Returns the current instance for method chaining.
	 */
	public function fgColor(Color $color, bool $isBright = false): static;

	/**
	 * Set the foreground color using a custom color from the palette.
	 *
	 * @param int $color  The color code between 0 - 255.
	 * @return static Returns the current instance for method chaining.
	 */
	public function fgPalette(int $color): static;

	/**
	 * Set the foreground color using RGB components.
	 *
	 * @param int $red  Red component (between 0 - 255).
	 * @param int $green  Green component (between 0 - 255).
	 * @param int $blue  Blue component (between 0 - 255).
	 * @return static Returns the current instance for method chaining.
	 */
	public function fgRgb(int $red, int $green, int $blue): static;

	/**
	 * Set the foreground color based on different color representations.
	 *
	 * @param Color|int|array $color The color to set. It can be an instance of Color, an integer (ANSI 256 color code), or an array of RGB values.
	 * @param bool $isBright Whether the color should be bright or not (applies to Color instance only).
	 * @return static
	 */
	public function fgColorize(Color|int|array $color, bool $isBright = false): static;

	/**
	 * Set the background color using the specified color and brightness.
	 *
	 * @param Color $color  The background color enumeration.
	 * @param bool $isBright Whether to use the bright color.
	 * @return static Returns the current instance for method chaining.
	 */
	public function bgColor(Color $color, bool $isBright = false): static;

	/**
	 * Set the background color using a custom color from the palette.
	 *
	 * @param int $color  The color code between 0 - 255.
	 * @return static Returns the current instance for method chaining.
	 */
	public function bgPalette(int $color): static;

	/**
	 * Set the background color using RGB components.
	 *
	 * @param int $red  Red component (between 0 - 255).
	 * @param int $green  Green component (between 0 - 255).
	 * @param int $blue  Blue component (between 0 - 255).
	 * @return static Returns the current instance for method chaining.
	 */
	public function bgRgb(int $red, int $green, int $blue): static;

	/**
	 * Set the background color based on different color representations.
	 *
	 * @param Color|int|array $color The color to set. It can be an instance of Color, an integer (ANSI 256 color code), or an array of RGB values.
	 * @param bool $isBright Whether the color should be bright or not (applies to Color instance only).
	 * @return static
	 */
	public function bgColorize(Color|int|array $color, bool $isBright = false): static;
}
