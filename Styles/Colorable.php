<?php

declare(strict_types=1);

namespace Inspira\Console\Styles;

use Inspira\Console\Contracts\ColorInterface;
use Inspira\Console\Enums\Color;
use InvalidArgumentException;

/**
 * Trait Colorable
 *
 * Trait providing methods for setting foreground and background colors in a console output.
 * This trait is used only in Styles class. This is just to separate color related methods
 * for better maintainability.
 *
 * @property ColorInterface $fgColor  The foreground color instance.
 * @property ColorInterface $bgColor  The background color instance.
 */
trait Colorable
{
	/**
	 * @var array Text fg and bg colors
	 */
	protected array $colors = [];

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
	 * Set the foreground color based on different color representations.
	 *
	 * @param Color|int|array $color The color to set. It can be an instance of Color, an integer (ANSI 256 color code), or an array of RGB values.
	 * @param bool $isBright Whether the color should be bright or not (applies to Color instance only).
	 * @return static
	 */
	public function fgColorize(Color|int|array $color, bool $isBright = false): static
	{
		if ($color instanceof Color) {
			return $this->fgColor($color, $isBright);
		}

		if (is_int($color)) {
			return $this->fgPalette($color);
		}

		if (count($color) !== 3) {
			throw new InvalidArgumentException("Please provide an array of [red, green, blue] colors based on ANSI 256.");
		}

		return $this->fgRgb(...$color);
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

	/**
	 * Reset colors.
	 *
	 * @return static
	 */
	protected function resetColors(): static
	{
		$this->colors = [];

		return $this;
	}
}
