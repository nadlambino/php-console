<?php

declare(strict_types=1);

namespace Inspira\Console\Output;

use Inspira\Console\Enums\Color as ColorEnum;

/**
 * Class Styles
 *
 * Represents text styles and colors using ANSI escape codes.
 *
 * @package Inspira\Console\Output
 */
class Styles
{
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
	 * @var array Text styles
	 */
	protected array $styles = [];

	/**
	 * @var array Text fg and bg colors
	 */
	protected array $colors = [];

	/**
	 * Styles constructor.
	 *
	 * @param string|null $text     The text to apply styles to.
	 * @param Color|null  $fgColor  The foreground color.
	 * @param Color|null  $bgColor  The background color.
	 */
	public function __construct(
		protected ?string $text = null,
		protected ?Color $fgColor = null,
		protected ?Color $bgColor = null
	) {
		$this->fgColor ??= new FgColor();
		$this->bgColor ??= new BgColor();
	}

	/**
	 * Set the foreground color for the text.
	 *
	 * @param ColorEnum $color     The foreground color.
	 * @param bool      $isBright  Whether to use the bright version of the color.
	 *
	 * @return $this
	 */
	public function foreground(ColorEnum $color, bool $isBright = false): self
	{
		$fg = $isBright ? $this->fgColor->bright() : $this->fgColor->reset();
		$this->colors[] = $fg->color($color);

		return $this;
	}

	/**
	 * Set the background color for the text.
	 *
	 * @param ColorEnum $color     The background color.
	 * @param bool      $isBright  Whether to use the bright version of the color.
	 *
	 * @return $this
	 */
	public function background(ColorEnum $color, bool $isBright = false): self
	{
		$bg = $isBright ? $this->bgColor->bright() : $this->bgColor->reset();
		$this->colors[] = $bg->color($color);

		return $this;
	}

	/**
	 * Apply bold style to the text.
	 *
	 * @return $this
	 */
	public function bold(): self
	{
		$this->styles[] = self::BOLD;

		return $this;
	}

	/**
	 * Apply muted style to the text
	 *
	 * @return $this
	 */
	public function muted(): self
	{
		$this->styles[] = self::MUTED;

		return $this;
	}

	/**
	 * Apply italic style to the text.
	 *
	 * @return $this
	 */
	public function italic(): self
	{
		$this->styles[] = self::ITALIC;

		return $this;
	}

	/**
	 * Apply underlined style to the text.
	 *
	 * @return $this
	 */
	public function underlined(): self
	{
		$this->styles[] = self::UNDERLINED;

		return $this;
	}

	/**
	 * Apply invert style to the text (swap foreground and background colors).
	 *
	 * @return $this
	 */
	public function invert(): self
	{
		$this->styles[] = self::INVERT;

		return $this;
	}

	/**
	 * Reset all styles and colors.
	 *
	 * @return $this
	 */
	public function reset(): self
	{
		$this->styles = [];
		$this->colors = [];

		return $this;
	}

	/**
	 * Apply the defined styles to the given text or the text set in the constructor.
	 *
	 * @param string|null $text  The text to apply styles to. If null, uses the text set in the constructor.
	 *
	 * @return string
	 */
	public function apply(?string $text = null): string
	{
		$text ??= $this->text;

		return $this->startStyle() . $text . $this->endStyle();
	}

	/**
	 * Generate the ANSI escape code for starting the defined styles.
	 *
	 * @return string
	 */
	private function startStyle(): string
	{
		$styles = array_merge($this->styles, $this->colors);
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
