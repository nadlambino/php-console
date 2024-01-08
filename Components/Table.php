<?php

declare(strict_types=1);

namespace Inspira\Console\Components;

use Inspira\Console\Contracts\ComponentInterface;
use Inspira\Console\Enums\Color;
use Inspira\Console\Output;

/**
 * Class Table
 *
 * A console component implementation for rendering tabular data in a table format.
 *
 * @package Inspira\Console\Components
 */
class Table implements ComponentInterface
{
	/**
	 * @var array<string, int> The count of the longest characters for each column.
	 */
	protected array $columnWidths = [];

	/**
	 * @var string The table caption.
	 */
	protected string $caption = '';

	/**
	 * @var int The caption text color based on ANSI 256.
	 */
	private int $captionFg = 0;

	/**
	 * @var int The caption background color based on ANSI 256.
	 */
	private int $captionBg = 2;

	/**
	 * @var int The caption alignment.
	 */
	private int $captionAlignment = STR_PAD_BOTH;

	/**
	 * Table constructor.
	 *
	 * @param Output $output The output instance for writing to the console.
	 * @param array $data The tabular data to be displayed in the table.
	 * @param int $padding The padding to be applied to each column in the table.
	 * @param int $headerPadding The padding to be applied in headers.
	 */
	public function __construct(
		protected Output $output,
		protected array  $data,
		protected int    $padding = 3,
		protected int    $headerPadding = 9
	)
	{
		$this->prependHeaders($this->getHeaders())
			->setColumnWidths()
			->removeHeaders();
	}

	/**
	 * Table caption.
	 *
	 * @param string $caption The caption.
	 * @param int $alignment The caption alignment. Accepted values are 0, 1, or 2, or STR_PAD_LEFT, STR_PAD_RIGHT, or STR_PAD_BOTH.
	 * @param int $fgColor The caption text color based from ANSI 256 (0 - 255).
	 * @param int $bgColor The caption background color based from ANSI 256 (0 - 255).
	 * @return $this
	 */
	public function caption(string $caption, int $alignment = STR_PAD_BOTH, int $fgColor = 0, int $bgColor = 2): static
	{
		$acceptedAlignments = [STR_PAD_LEFT, STR_PAD_RIGHT, STR_PAD_BOTH];
		if (!in_array($alignment, $acceptedAlignments)) {
			$this->output->error("Invalid alignment, accepted values are 0, 1, or 2, or STR_PAD_LEFT, STR_PAD_RIGHT, or STR_PAD_BOTH");
		}

		$this->caption = $caption;
		$this->captionFg = $fgColor;
		$this->captionBg = $bgColor;
		$this->captionAlignment = $alignment;

		return $this;
	}

	/**
	 * Render the table by printing headers and body to the console.
	 *
	 * If the data is empty, no output will be generated.
	 *
	 * @return void
	 */
	public function render(): void
	{
		$this->printCaption()
			->printHeaders()
			->printBody();
	}

	/**
	 * Get the headers of the table based on the first row of data.
	 * This assumes that the items from the data are in similar structure.
	 *
	 * @return array The headers of the table.
	 */
	protected function getHeaders(): array
	{
		$columns = array_keys($this->data[0] ?? []);

		$headers = [];
		foreach ($columns as $column) {
			$headers[$column] = ucwords($column);
		}

		return $headers;
	}

	/**
	 * Prepend headers to the data array.
	 * This is to include the headers when counting the longest character in each column.
	 *
	 * @param array $headers The headers to be prepended.
	 *
	 * @return $this
	 */
	protected function prependHeaders(array $headers): static
	{
		array_unshift($this->data, $headers);

		return $this;
	}

	/**
	 * Remove the headers from the data array.
	 * After the characters has been counted, we now need to remove the prepended headers to avoid printing it out.
	 *
	 * @return $this
	 */
	protected function removeHeaders(): static
	{
		array_shift($this->data);

		return $this;
	}

	/**
	 * Set the width to be applied for each column by getting the longest character count of each column.
	 * The data should also include the headers to properly align the headers when printing out.
	 *
	 * @return $this
	 */
	protected function setColumnWidths(): static
	{
		foreach ($this->data as $row) {
			foreach ($row as $column => $value) {
				$length = strlen($value);
				if (!isset($this->columnWidths[$column]) || $length > $this->columnWidths[$column]) {
					$this->columnWidths[$column] = $length + $this->padding;
				}
			}
		}

		return $this;
	}

	/**
	 * Print the caption to the console with proper formatting and coloring.
	 *
	 * @return $this
	 */
	protected function printCaption(): static
	{
		if (empty($this->caption)) {
			return $this;
		}

		$widths = array_values($this->columnWidths);
		$totalWidth = array_sum($widths);
		$paddedCaption = str_pad($this->caption, $totalWidth, ' ', $this->captionAlignment);
		$styledCaption = $this
			->output
			->styles
			->fgPalette($this->captionFg)
			->bgPalette($this->captionBg)
			->apply($paddedCaption);

		$this->output->writeln($styledCaption);

		return $this;
	}

	/**
	 * Print the headers to the console with proper formatting and coloring.
	 *
	 * @return $this
	 */
	protected function printHeaders(): static
	{
		foreach (array_keys($this->columnWidths) as $column) {
			$coloredColumn = $this->output->colorize(ucwords($column), Color::GREEN);
			$width = $this->columnWidths[$column] + $this->headerPadding;
			$text = str_pad($coloredColumn, $width);
			$this->output->write($text);
		}
		$this->output->eol();

		return $this;
	}

	/**
	 * Print the body of the table to the console.
	 *
	 * @return $this
	 */
	protected function printBody(): static
	{
		foreach ($this->data as $row) {
			foreach ($row as $column => $value) {
				$text = str_pad($value, $this->columnWidths[$column]);
				$this->output->write($text);
			}
			$this->output->eol();
		}

		return $this;
	}
}
