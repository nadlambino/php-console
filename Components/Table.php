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
	protected array $columnWidths = [];

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
		$this->prependHeaders($this->getHeaders())
			->setColumnWidths()
			->removeHeaders();
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
		$this->printHeaders()->printBody();
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
	protected function prependHeaders(array $headers): self
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
	 * Set the width to be applied for each column by getting the longest character count of each column.
	 * The data should also include the headers to properly align the headers when printing out.
	 *
	 * @return $this
	 */
	protected function setColumnWidths(): self
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
	 * Print the headers to the console with proper formatting and coloring.
	 *
	 * @return $this
	 */
	protected function printHeaders(): self
	{
		foreach (array_keys($this->columnWidths) as $column) {
			$coloredColumn = $this->output->colorize(ucwords($column), Colors::GREEN);
			$width = $this->columnWidths[$column] + strlen(Colors::GREEN->value) + 4;
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
	protected function printBody(): self
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
