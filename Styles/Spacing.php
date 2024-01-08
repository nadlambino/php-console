<?php

declare(strict_types=1);

namespace Inspira\Console\Styles;

/**
 * Trait Spacing
 *
 * Trait providing methods for text spacing customization.
 *
 * @property string $text The text content to be manipulated.
 * @property bool $isDeferred Flag indicating whether spacing methods should be deferred.
 */
trait Spacing
{
	/**
	 * Add padding to the left side of the text.
	 *
	 * @param int $padding The number of spaces to add to the left side of the text.
	 *
	 * @return static Returns an instance of the class for method chaining.
	 */
	public function paddingLeft(int $padding): static
	{
		if ($this->shouldSpacingMethodsDeferred()) {
			return $this->defer(func_get_args());
		}

		$this->text = str_pad($this->text, strlen($this->text) + $padding, ' ', STR_PAD_LEFT);

		return $this;
	}

	/**
	 * Add padding to the right side of the text.
	 *
	 * @param int $padding The number of spaces to add to the right side of the text.
	 *
	 * @return static Returns an instance of the class for method chaining.
	 */
	public function paddingRight(int $padding): static
	{
		if ($this->shouldSpacingMethodsDeferred()) {
			return $this->defer(func_get_args());
		}

		$this->text = str_pad($this->text, strlen($this->text) + $padding, ' ', STR_PAD_RIGHT);

		return $this;
	}

	/**
	 * Add padding to both sides of the text.
	 *
	 * @param int $padding The number of spaces to add to both sides of the text.
	 *
	 * @return static Returns an instance of the class for method chaining.
	 */
	public function paddingX(int $padding): static
	{
		if ($this->shouldSpacingMethodsDeferred()) {
			return $this->defer(func_get_args());
		}

		$this->text = str_pad($this->text, strlen($this->text) + $padding, ' ', STR_PAD_BOTH);

		return $this;
	}

	/**
	 * Check whether spacing methods should be deferred based on the isDeferred property and text content.
	 *
	 * @return bool Returns true if spacing methods should be deferred; otherwise, false.
	 */
	protected function shouldSpacingMethodsDeferred(): bool
	{
		return $this->isDeferred === true || empty($this->text);
	}
}
