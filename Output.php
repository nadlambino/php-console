<?php

declare(strict_types=1);

namespace Inspira\Console;

use Inspira\Console\Enums\Colors;

/**
 * Class Output
 *
 * Handles console output and formatting.
 *
 * @package Inspira\Console
 */
class Output
{
	/**
	 * The max count of ANSI color characters.
	 * This is used to be added in the str_pad width.
	 */
	const ANSI_CHAR_COUNT = 9;

	/**
	 * Display a success message with optional exit.
	 *
	 * @param string $message The success message.
	 * @param bool $exit Whether to exit after displaying the message.
	 *
	 * @return void
	 */
	public function success(string $message, bool $exit = true): void
	{
		echo $this->colorize($message, Colors::GREEN) . PHP_EOL;

		if ($exit) {
			exit(0);
		}
	}

	/**
	 * Display an info message with optional exit.
	 *
	 * @param string $message The info message.
	 * @param bool $exit Whether to exit after displaying the message.
	 *
	 * @return void
	 */
	public function info(string $message, bool $exit = true): void
	{
		echo $this->colorize($message, Colors::BLUE) . PHP_EOL;

		if ($exit) {
			exit(0);
		}
	}

	/**
	 * Display a warning message with optional exit.
	 *
	 * @param string $message The warning message.
	 * @param bool $exit Whether to exit after displaying the message.
	 *
	 * @return void
	 */
	public function warning(string $message, bool $exit = true): void
	{
		echo $this->colorize($message, Colors::YELLOW) . PHP_EOL;

		if ($exit) {
			exit(2);
		}
	}

	/**
	 * Display an error message with optional exit.
	 *
	 * @param string $message The error message.
	 * @param bool $exit Whether to exit after displaying the message.
	 *
	 * @return void
	 */
	public function error(string $message, bool $exit = true): void
	{
		echo $this->colorize($message, Colors::RED) . PHP_EOL;

		if ($exit) {
			exit(1);
		}
	}

	/**
	 * Apply ANSI color to a message.
	 *
	 * @param string $message The message to colorize.
	 * @param Colors|string $ansiColor The ANSI color to apply.
	 *
	 * @return string The colorized message.
	 */
	public function colorize(string $message, Colors|string $ansiColor): string
	{
		$color = $ansiColor instanceof Colors ? $ansiColor->value : $ansiColor;

		return $color . $message . Colors::BASE->value;
	}

	/**
	 * Display a table with formatted data.
	 *
	 * @param array $data The data to display in the table.
	 * @param int $spacing The spacing between columns.
	 *
	 * @return void
	 */
	public function table(array $data, int $spacing = 20): void
	{
		if (empty($data)) {
			return;
		}

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
