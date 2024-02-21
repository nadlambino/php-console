<?php

declare(strict_types=1);

namespace Inspira\Console\Contracts;

/**
 * Interface StylesInterface
 *
 * Interface defining methods for representing text styles and colors using ANSI escape codes.
 */
interface StylesInterface extends FormatInterface, SpacingInterface, ColorableInterface
{
	/**
	 * Reset all styles and colors.
	 *
	 * @return static
	 */
	public function reset(): static;

	/**
	 * Apply the defined styles to the given text or the text set in the constructor.
	 *
	 * @param string|null $text  The text to apply styles to. If null, uses the text set in the constructor.
	 *
	 * @return string
	 */
	public function apply(?string $text = null): string;
}
