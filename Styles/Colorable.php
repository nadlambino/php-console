<?php

declare(strict_types=1);

namespace Inspira\Console\Styles;

use Inspira\Console\Contracts\ColorInterface;
use Inspira\Console\Enums\Color;

/**
 * Trait Colorable
 *
 * Trait providing methods for setting foreground and background colors in a console output.
 * This trait is used only in Styles class. This is just to separate color related methods
 * for better maintainability.
 *
 * @property ColorInterface $fgColor  The foreground color instance.
 * @property ColorInterface $bgColor  The background color instance.
 * @property array $colors  Array to store ANSI escape codes for colors.
 */
trait Colorable
{
	/**
	 * Set the foreground color using the specified color and brightness.
	 *
	 * @param Color $color  The foreground color enumeration.
	 * @param bool $isBright Whether to use the bright color.
	 * @return static  Returns the current instance for method chaining.
	 */
	public function fgColor(Color $color, bool $isBright = false): static
	{
		$this->colors[] = $this->fgColor->color($color, $isBright);

		return $this;
	}

	/**
	 * Set the foreground color using a custom color from the palette.
	 *
	 * @param int $color  The color code between 0 - 255.
	 * @return static  Returns the current instance for method chaining.
	 *
	 * @link https://en.wikipedia.org/wiki/ANSI_escape_code
	 */
	public function fgPalette(int $color): static
	{
		$this->colors[] = $this->fgColor->palette($color);

		return $this;
	}

	/**
	 * Set the foreground color using RGB components.
	 *
	 * @param int $red  Red component (between 0 - 255).
	 * @param int $green  Green component (between 0 - 255).
	 * @param int $blue  Blue component (between 0 - 255).
	 * @return static  Returns the current instance for method chaining.
	 *
	 * @link https://en.wikipedia.org/wiki/ANSI_escape_code
	 */
	public function fgRgb(int $red, int $green, int $blue): static
	{
		$this->colors[] = $this->fgColor->rgb($red, $green, $blue);

		return $this;
	}

	/**
	 * Set the background color using the specified color and brightness.
	 *
	 * @param Color $color  The background color enumeration.
	 * @param bool $isBright Whether to use the bright color.
	 * @return static  Returns the current instance for method chaining.
	 */
	public function bgColor(Color $color, bool $isBright = false): static
	{
		$this->colors[] = $this->bgColor->color($color, $isBright);

		return $this;
	}

	/**
	 * Set the background color using a custom color from the palette.
	 *
	 * @param int $color  The color code between 0 - 255.
	 * @return static  Returns the current instance for method chaining.
	 */
	public function bgPalette(int $color): static
	{
		$this->colors[] = $this->bgColor->palette($color);

		return $this;
	}

	/**
	 * Set the background color using RGB components.
	 *
	 * @param int $red  Red component (between 0 - 255).
	 * @param int $green  Green component (between 0 - 255).
	 * @param int $blue  Blue component (between 0 - 255).
	 * @return static  Returns the current instance for method chaining.
	 */
	public function bgRgb(int $red, int $green, int $blue): static
	{
		$this->colors[] = $this->bgColor->rgb($red, $green, $blue);

		return $this;
	}
}
