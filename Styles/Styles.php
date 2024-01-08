<?php

declare(strict_types=1);

namespace Inspira\Console\Styles;

use Inspira\Console\Contracts\ColorInterface;
use Inspira\Console\Contracts\StylesInterface;

/**
 * Class Styles
 *
 * Represents text styles and colors using ANSI escape codes.
 *
 * @package Inspira\Console\Output
 */
class Styles implements StylesInterface
{
	use Colorable, Formattable, Spacing;

	/**
	 * ANSI escape sequence
	 */
	protected const ESC = "\033";

	/**
	 * ANSI start sequence
	 */
	protected const START = '[';

	/**
	 * ANSI end sequence
	 */
	protected const END = 'm';

	/**
	 * ANSI reset code
	 */
	protected const RESET = 0;

	/**
	 * ANSI bold code
	 */
	public const BOLD = 1;

	/**
	 * ANSI muted code
	 */
	public const MUTED = 2;

	/**
	 * ANSI italic code
	 */
	public const ITALIC = 3;

	/**
	 * ANSI underlined code
	 */
	public const UNDERLINED = 4;

	/**
	 * ANSI invert code
	 */
	public const INVERT = 7;

	/**
	 * Styles constructor.
	 *
	 * @param string|null $text     The text to apply styles to.
	 * @param ColorInterface|null  $fgColor  The foreground color.
	 * @param ColorInterface|null  $bgColor  The background color.
	 */
	public function __construct(
		protected ?string $text = null,
		protected ?ColorInterface $fgColor = null,
		protected ?ColorInterface $bgColor = null
	) {
		$this->fgColor ??= new FgColor();
		$this->bgColor ??= new BgColor();
	}

	/**
	 * Make new style.
	 *
	 * @return static
	 */
	public static function make(): static
	{
		return (new static());
	}

	/**
	 * Reset all styles and colors.
	 *
	 * @return Styles
	 */
	public function reset(): static
	{
		$this->resetFormats()
			->resetColors()
			->resetPaddings();

		return $this;
	}

	/**
	 * Apply the defined styles to the given text or the text set in the constructor.
	 *
	 * @param string|null $text The text to apply styles to. If null, uses the text set in the constructor.
	 * @param bool $reset Whether to reset the style for next use.
	 * @return string
	 */
	public function apply(?string $text = null, bool $reset = false): string
	{
		$this->text = $text ?? $this->text;
		$this->applyPaddings();

		$stylized = $this->startStyle() . $this->text . $this->endStyle();

		if ($reset === true) {
			$this->reset();
		}

		return $stylized;
	}

	/**
	 * Generate the ANSI escape code for starting the defined styles.
	 *
	 * @return string
	 */
	private function startStyle(): string
	{
		$styles = array_merge($this->formats, $this->colors);
		$styles = implode(';', $styles);

		return self::ESC . self::START . $styles . self::END;
	}

	/**
	 * Generate the ANSI escape code for resetting styles.
	 *
	 * @return string
	 */
	private function endStyle(): string
	{
		return self::ESC . self::START . self::RESET . self::END;
	}
}
