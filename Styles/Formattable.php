<?php

declare(strict_types=1);

namespace Inspira\Console\Styles;

/**
 * Trait Formattable
 *
 * Trait providing methods for formatting texts in a console output.
 * This trait is used only in Styles class. This is just to separate color related methods
 * for better maintainability.
 *
 * @property array $styles
 */
trait Formattable
{
	/**
	 * Apply bold style to the text.
	 *
	 * @return Styles
	 */
	public function bold(): static
	{
		$this->styles[] = self::BOLD;

		return $this;
	}

	/**
	 * Apply muted style to the text
	 *
	 * @return Styles
	 */
	public function muted(): static
	{
		$this->styles[] = self::MUTED;

		return $this;
	}

	/**
	 * Apply italic style to the text.
	 *
	 * @return Styles
	 */
	public function italic(): static
	{
		$this->styles[] = self::ITALIC;

		return $this;
	}

	/**
	 * Apply underlined style to the text.
	 *
	 * @return Styles
	 */
	public function underlined(): static
	{
		$this->styles[] = self::UNDERLINED;

		return $this;
	}

	/**
	 * Apply invert style to the text (swap foreground and background colors).
	 *
	 * @return Styles
	 */
	public function invert(): static
	{
		$this->styles[] = self::INVERT;

		return $this;
	}
}
