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
	 * @var array Associative array containing padding values for different directions.
	 */
	protected array $paddings = [
		'top' => 0,
		'right' => 0,
		'bottom' => 0,
		'left' => 0
	];

	/**
	 * Add padding to the left side of the text.
	 *
	 * @param int $padding The number of spaces to add to the left side of the text.
	 *
	 * @return static Returns an instance of the class for method chaining.
	 */
	public function paddingLeft(int $padding): static
	{
		$this->paddings['left'] = $padding;

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
		$this->paddings['right'] = $padding;

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
		$this->paddings['left'] = $padding;
		$this->paddings['right'] = $padding;

		return $this;
	}

	/**
	 * Add padding to the top of the text.
	 *
	 * Note: The Y axis padding (top and bottom) uses a new line as padding.
	 *
	 * @param int $padding The number of empty lines to add to the top of the text.
	 *
	 * @return static Returns an instance of the class for method chaining.
	 */
	public function paddingTop(int $padding): static
	{
		$this->paddings['top'] = $padding;

		return $this;
	}

	/**
	 * Add padding to the bottom of the text.
	 *
	 * Note: The Y axis padding (top and bottom) uses a new line as padding.
	 *
	 * @param int $padding The number of empty lines to add to the bottom of the text.
	 *
	 * @return static Returns an instance of the class for method chaining.
	 */
	public function paddingBottom(int $padding): static
	{
		$this->paddings['bottom'] = $padding;

		return $this;
	}

	/**
	 * Add padding to both the top and bottom of the text.
	 *
	 * Note: The Y axis padding (top and bottom) uses a new line as padding.
	 *
	 * @param int $padding The number of empty lines to add to both the top and bottom of the text.
	 *
	 * @return static Returns an instance of the class for method chaining.
	 */
	public function paddingY(int $padding): static
	{
		$this->paddings['top'] = $padding;
		$this->paddings['bottom'] = $padding;

		return $this;
	}

	/**
	 * Apply the defined paddings to the text.
	 *
	 * @return static Returns an instance of the class for method chaining.
	 */
	public function applyPaddings(): static
	{
		extract($this->paddings);

		$text = $this->text;

		// Apply left padding
		$text = str_pad($text, strlen($text) + $left, ' ', STR_PAD_LEFT);

		// Apply right padding. Append a non-zero space in the end to avoid spaces being trimmed out
		$padded = str_pad($text, strlen($text) + $right, ' ', STR_PAD_RIGHT);

		// Create top padding
		$textLength = strlen($padded);
		$topLine = str_repeat(" ", $textLength) . PHP_EOL;
		$topPadding = str_repeat($topLine, $top);

		// Create bottom padding
		$bottomLine = PHP_EOL . str_repeat(" ", $textLength);
		$bottomPadding = str_repeat($bottomLine, $bottom);

		$this->text = $topPadding . $padded . $bottomPadding;

		return $this;
	}

	/**
	 * Reset the values of paddings.
	 *
	 * @return static
	 */
	protected function resetPaddings(): static
	{
		$this->paddings = [
			'top' => 0,
			'right' => 0,
			'bottom' => 0,
			'left' => 0
		];

		return $this;
	}
}
