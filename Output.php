<?php

declare(strict_types=1);

namespace Inspira\Console;

class Output
{
	/**
	 * The max count of ansi color characters
	 * This is used to be added in the str_pad width
	 */
	const ANSI_CHAR_COUNT = 9;

	public function success(string $message, bool $exit = true): void
	{
		echo $this->colorize($message, Colors::GREEN) . PHP_EOL;

		if ($exit) {
			exit(0);
		}
	}

	public function info(string $message, bool $exit = true): void
	{
		echo $this->colorize($message, Colors::BLUE) . PHP_EOL;

		if ($exit) {
			exit(0);
		}
	}

	public function warning(string $message, bool $exit = true): void
	{
		echo $this->colorize($message, Colors::YELLOW) . PHP_EOL;

		if ($exit) {
			exit(2);
		}
	}

	public function error(string $message, bool $exit = true): void
	{
		echo $this->colorize($message, Colors::RED) . PHP_EOL;

		if ($exit) {
			exit(1);
		}
	}

	public function colorize(string $message, Colors|string $ansiColor): string
	{
		$color = $ansiColor instanceof Colors ? $ansiColor->value : $ansiColor;

		return $color . $message . Colors::BASE->value;
	}

	public function table(array $data, int $spacing = 20): void
	{
		$columns = array_keys($data[0]);
		$widths = [];

		$headers = [];
		foreach ($columns as $column) {
			$headers[$column] = ucwords($column);
		}

		array_unshift($data, $headers);

		foreach ($columns as $column) {
			$widths[$column] = max(array_map('strlen', [$column])) + $spacing;
		}

		foreach ($data as $dataIndex => $row) {
			foreach ($columns as $columnIndex => $column) {
				$raw = $row[$column] ?? '';
				$value = $dataIndex === 0 ? $this->colorize($raw, Colors::BLUE) : $raw;
				$value = $columnIndex === 0 ? $this->colorize($value, Colors::GREEN) : $value;
				$value = empty($value) ? '-' : $value;
				$width = $dataIndex === 0 ? $widths[$column] + self::ANSI_CHAR_COUNT : $widths[$column];

				echo str_pad($value, $width);
			}

			echo PHP_EOL;
		}
	}
}
