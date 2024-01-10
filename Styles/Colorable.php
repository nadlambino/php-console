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
	 * {@inheritdoc}
	 */
	public function fgColor(Color $color, bool $isBright = false): static
	{
		$this->colors[] = $this->fgColor->color($color, $isBright);

		return $this;
	}

	/**
	 * {@inheritdoc}
	 * @link https://en.wikipedia.org/wiki/ANSI_escape_code
	 */
	public function fgPalette(int $color): static
	{
		$this->colors[] = $this->fgColor->palette($color);

		return $this;
	}

	/**
	 * {@inheritdoc}
	 * @link https://en.wikipedia.org/wiki/ANSI_escape_code
	 */
	public function fgRgb(int $red, int $green, int $blue): static
	{
		$this->colors[] = $this->fgColor->rgb($red, $green, $blue);

		return $this;
	}

	/**
	 * {@inheritdoc}
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
	 * Method alias for fgColorize.
	 *
	 * @param Color|int|array $color The color to set. It can be an instance of Color, an integer (ANSI 256 color code), or an array of RGB values.
	 * @param bool $isBright Whether the color should be bright or not (applies to Color instance only).
	 * @return static
	 */
	public function color(Color|int|array $color, bool $isBright = false): static
	{
		return $this->fgColorize($color, $isBright);
	}

	/**
	 * {@inheritdoc}
	 */
	public function bgColor(Color $color, bool $isBright = false): static
	{
		$this->colors[] = $this->bgColor->color($color, $isBright);

		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function bgPalette(int $color): static
	{
		$this->colors[] = $this->bgColor->palette($color);

		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function bgRgb(int $red, int $green, int $blue): static
	{
		$this->colors[] = $this->bgColor->rgb($red, $green, $blue);

		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function bgColorize(Color|int|array $color, bool $isBright = false): static
	{
		if ($color instanceof Color) {
			return $this->bgColor($color, $isBright);
		}

		if (is_int($color)) {
			return $this->bgPalette($color);
		}

		if (count($color) !== 3) {
			throw new InvalidArgumentException("Please provide an array of [red, green, blue] colors based on ANSI 256.");
		}

		return $this->bgRgb(...$color);
	}

	/**
	 * Method alias for bgColorize.
	 *
	 * @param Color|int|array $color The color to set. It can be an instance of Color, an integer (ANSI 256 color code), or an array of RGB values.
	 * @param bool $isBright Whether the color should be bright or not (applies to Color instance only).
	 * @return static
	 */
	public function paint(Color|int|array $color, bool $isBright = false): static
	{
		return $this->bgColorize($color, $isBright);
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
