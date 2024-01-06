<?php

declare(strict_types=1);

namespace Inspira\Console\Components;

use Inspira\Console\Contracts\ComponentInterface;
use Inspira\Console\Enums\Colors;
use Inspira\Console\Output;

final class Table implements ComponentInterface
{
	public function __construct(protected Output $output, protected array $data, protected int $padding = 3)
	{
	}

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

	protected function getHeaders(): array
	{
		$columns = array_keys($this->data[0] ?? []);

		$headers = [];
		foreach ($columns as $column) {
			$headers[$column] = ucwords($column);
		}

		return $headers;

	}

	protected function appendHeaders(array $headers): self
	{
		array_unshift($this->data, $headers);

		return $this;
	}

	protected function removeHeaders(): self
	{
		array_shift($this->data);

		return $this;
	}

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

	protected function printHeaders(array $columnWidths): self
	{
		foreach (array_keys($columnWidths) as $column) {
			$text = str_pad($this->output->colorize(ucwords($column), Colors::GREEN), $columnWidths[$column] + strlen(Colors::GREEN->value) + 4);
			$this->output->write($text);
		}
		$this->output->eol();

		return $this;
	}

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
