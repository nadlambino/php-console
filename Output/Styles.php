<?php

namespace Inspira\Console\Output;

class Styles
{
	protected const ESC = "\033";
	protected const START = '[';
	protected const END = 'm';
	protected const RESET = 0;
	public const BOLD = 1;
	public const MUTED = 2;
	public const ITALIC = 3;
	public const UNDERLINED = 4;
	public const INVERT = 7;

	protected array $styles = [];

	protected array $colors = [];

	public function __construct(protected string $text, protected ?Color $fgColor = null, protected ?Color $bgColor = null)
	{
		$this->fgColor ??= new FgColor();
		$this->bgColor ??= new BgColor();
	}

	public function foreground(int $colorCode, bool $isBright = false): self
	{
		$color = $isBright ? $this->fgColor->bright() : $this->fgColor;
		$this->colors[] = $color->color($colorCode);

		return $this;
	}

	public function background(int $colorCode, bool $isBright = false): self
	{
		$color = $isBright ? $this->bgColor->bright() : $this->bgColor;
		$this->colors[] = $color->color($colorCode);

		return $this;
	}

	public function bold(): self
	{
		$this->styles[] = self::BOLD;

		return $this;
	}

	public function italic(): self
	{
		$this->styles[] = self::ITALIC;

		return $this;
	}

	public function underlined(): self
	{
		$this->styles[] = self::UNDERLINED;

		return $this;
	}

	public function invert(): self
	{
		$this->styles[] = self::INVERT;

		return $this;
	}

	public function reset(): self
	{
		$this->styles = [];
		$this->colors = [];

		return $this;
	}

	public function apply(): string
	{
		return $this->startStyle() . $this->text . $this->endStyle();
	}

	private function startStyle(): string
	{
		$styles = array_merge($this->styles, $this->colors);
		$styles = implode(';', $styles);

		return self::ESC . self::START . $styles . self::END;
	}

	private function endStyle(): string
	{
		return self::ESC . self::START . self::RESET . self::END;
	}
}
