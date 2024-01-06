<?php

namespace Inspira\Console\Output;

use Inspira\Console\Enums\Color as ColorEnum;

abstract class Color
{
	protected bool $isBright = false;

	public function bright(): static
	{
		$this->isBright = true;

		return $this;
	}

	public function color(ColorEnum $color): string
	{
		$brightness = $this->isBright ? static::BRIGHT : static::NORMAL;

		return $brightness . $color->value;
	}

	public function reset(): static
	{
		$this->isBright = false;

		return $this;
	}
}
