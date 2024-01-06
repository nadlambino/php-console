<?php

namespace Inspira\Console\Output;

abstract class Color
{
	public const BLACK = 0;
	public const RED = 1;
	public const GREEN = 2;
	public const YELLOW = 3;
	public const BLUE = 4;
	public const MAGENTA = 5;
	public const CYAN = 6;
	public const WHITE = 7;
	public const DEFAULT = 9;

	protected bool $isBright = false;

	public function bright(): static
	{
		$this->isBright = true;

		return $this;
	}

	public function color(int $colorCode): string
	{
		$brightness = $this->isBright ? static::BRIGHT : static::NORMAL;

		return $brightness . $colorCode;
	}
}
