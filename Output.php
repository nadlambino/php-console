<?php

declare(strict_types=1);

namespace Inspira\Console;

use Inspira\Console\Components\Table;
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
	public function __construct(protected mixed $stream = null)
	{
		if (!is_resource($this->stream)) {
			$this->stream = STDOUT;
		}
	}

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

	public function write(string $text): self
	{
		fwrite($this->stream, $text);

		return $this;
	}

	public function writeln(string $text): static
	{
		fwrite($this->stream, $text . PHP_EOL);

		return $this;
	}

	public function eol(): self
	{
		fwrite($this->stream, PHP_EOL);

		return $this;
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
	 * @param int $padding The spacing between columns.
	 *
	 * @return void
	 */
	public function table(array $data, int $padding = 3): void
	{
		(new Table($this, $data, $padding))->render();
	}
}
