<?php

declare(strict_types=1);

namespace Inspira\Console\Contracts;

/**
 * Interface FormatInterface
 *
 * Interface providing methods for formatting texts in a console output.
 * This interface is intended to be implemented by classes that need text formatting capabilities.
 */
interface FormatInterface
{
	/**
	 * Apply bold style to the text.
	 *
	 * @return static
	 */
	public function bold(): static;

	/**
	 * Apply muted style to the text.
	 *
	 * @return static
	 */
	public function muted(): static;

	/**
	 * Apply italic style to the text.
	 *
	 * @return static
	 */
	public function italic(): static;

	/**
	 * Apply underlined style to the text.
	 *
	 * @return static
	 */
	public function underlined(): static;

	/**
	 * Apply invert style to the text (swap foreground and background colors).
	 *
	 * @return static
	 */
	public function invert(): static;
}
