<?php

declare(strict_types=1);

namespace Inspira\Console\Components;

use Inspira\Console\Contracts\ComponentInterface;
use Inspira\Console\Enums\Colors;
use Inspira\Console\Output;

/**
 * Class Table
 *
 * A console component implementation for rendering tabular data in a table format.
 *
 * @package Inspira\Console\Components
 */
final class Table implements ComponentInterface
{
	/**
	 * Table constructor.
	 *
	 * @param Output $output The output instance for writing to the console.
	 * @param array $data The tabular data to be displayed in the table.
	 * @param int $padding The padding to be applied to each column in the table.
	 * @param int $coloredPadding The padding to be applied in colored headers.
	 */
	public function __construct(
		protected Output $output,
		protected array  $data,
		protected int    $padding = 3,
		protected int    $coloredPadding = 4
	)
	{
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
		if (empty($this->data)) {
			return;
		}

		$headers = $this->getHeaders();
		$columnWidths = $this->appendHeaders($headers)->getColumnWidths();

		$this->removeHeaders()
			->printHeaders($columnWidths)
			->printBody($columnWidths);
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
	protected function appendHeaders(array $headers): self
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
	protected function removeHeaders(): self
	{
		array_shift($this->data);

		return $this;
	}

	/**
	 * Get the longest character count for each column in the table data.
	 * The data should also include the headers to properly align the headers when printing out.
	 *
	 * @return array The widths of each column.
	 */
	protected function getColumnWidths(): array
	{
		$widths = [];

		foreach ($this->data as $row) {
			foreach ($row as $column => $value) {
				$length = strlen($value);
				if (!isset($widths[$column]) || $length > $widths[$column]) {
					$widths[$column] = $length + $this->padding;
				}
			}
		}

		return $widths;
	}

	/**
	 * Print the headers to the console with proper formatting and coloring.
	 *
	 * @param array $columnWidths The widths of each column.
	 *
	 * @return $this
	 */
	protected function printHeaders(array $columnWidths): self
	{
		foreach (array_keys($columnWidths) as $column) {
			$coloredColumn = $this->output->colorize(ucwords($column), Colors::GREEN);
			$width = $columnWidths[$column] + strlen(Colors::GREEN->value) + 4;
			$text = str_pad($coloredColumn, $width);
			$this->output->write($text);
		}
		$this->output->eol();

		return $this;
	}

	/**
	 * Print the body of the table to the console.
	 *
	 * @param array $columnWidths The widths of each column.
	 *
	 * @return $this
	 */
	protected function printBody(array $columnWidths): self
	{
		foreach ($this->data as $row) {
			foreach ($row as $column => $value) {
				$text = str_pad($value, $columnWidths[$column]);
				$this->output->write($text);
			}
			$this->output->eol();
		}

		return $this;
	}
}
