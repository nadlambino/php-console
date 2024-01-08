<?php

declare(strict_types=1);

namespace Inspira\Console\Styles;

/**
 * Trait Formattable
 *
 * Trait providing methods for formatting texts in a console output.
 * This trait is used only in Styles class. This is just to separate color related methods
 * for better maintainability.
 */
trait Formattable
{
	/**
	 * @var array Text formats
	 */
	protected array $formats = [];

	/**
	 * Apply bold style to the text.
	 *
	 * @return static
	 */
	public function bold(): static
	{
		$this->formats[] = self::BOLD;

		return $this;
	}

	/**
	 * Apply muted style to the text
	 *
	 * @return static
	 */
	public function muted(): static
	{
		$this->formats[] = self::MUTED;

		return $this;
	}

	/**
	 * Apply italic style to the text.
	 *
	 * @return static
	 */
	public function italic(): static
	{
		$this->formats[] = self::ITALIC;

		return $this;
	}

	/**
	 * Apply underlined style to the text.
	 *
	 * @return static
	 */
	public function underlined(): static
	{
		$this->formats[] = self::UNDERLINED;

		return $this;
	}

	/**
	 * Apply invert style to the text (swap foreground and background colors).
	 *
	 * @return static
	 */
	public function invert(): static
	{
		$this->formats[] = self::INVERT;

		return $this;
	}

	/**
	 * Reset formatting.
	 *
	 * @return static
	 */
	protected function resetFormats(): static
	{
		$this->formats = [];

		return $this;
	}
}
