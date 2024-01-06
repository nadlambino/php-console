<?php

declare(strict_types=1);

namespace Inspira\Console\Output;

use Inspira\Console\Components\Table;
use Inspira\Console\Enums\Color;

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
	 * Class constructor for the Output class.
	 *
	 * This constructor initializes the Output instance with an optional stream.
	 * If the provided stream is not a valid resource, it defaults to STDOUT (standard output).
	 *
	 * @param resource|null $stream An optional stream resource for output. Defaults to STDOUT if not provided or invalid.
	 */
	public function __construct(protected mixed $stream = null, public ?Styles $styles = null)
	{
		if (!is_resource($this->stream)) {
			$this->stream = STDOUT;
		}

		$this->styles ??= new Styles();
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
		$text = $this->colorize($message, Color::GREEN, true);
		$this->writeln($text);

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
		$text = $this->colorize($message, Color::BLUE, true);
		$this->writeln($text);

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
		$text = $this->colorize($message, Color::YELLOW);
		$this->writeln($text);

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
		$text = $this->colorize($message, Color::RED);
		$this->writeln($text);

		if ($exit) {
			exit(1);
		}
	}

	/**
	 * Write text to the output stream.
	 *
	 * @param string $text The text to be written.
	 *
	 * @return $this
	 */
	public function write(string $text): self
	{
		fwrite($this->stream, $text);

		return $this;
	}

	/**
	 * Write a line of text to the output stream with a newline character.
	 *
	 * @param string $text The text to be written.
	 *
	 * @return static
	 */
	public function writeln(string $text): static
	{
		fwrite($this->stream, $text . PHP_EOL);

		return $this;
	}

	/**
	 * Write a newline character to the output stream.
	 *
	 * @return $this
	 */
	public function eol(): self
	{
		fwrite($this->stream, PHP_EOL);

		return $this;
	}

	/**
	 * Apply ANSI color to a message.
	 *
	 * @param string $message The message to colorize.
	 * @param Color $color The ANSI color code.
	 * @param bool $isBright Whether to use ANSI bright color.
	 * @return string The colorized message.
	 */
	public function colorize(string $message, Color $color, bool $isBright = false): string
	{
		return $this->styles->reset()->foreground($color, $isBright)->apply($message);
	}

	/**
	 * Display a table in the console.
	 *
	 * This method creates a new Table instance, initializes it with the provided data and padding,
	 * and then renders the table to the console using the render method of the Table class.
	 *
	 * @param array $data The tabular data to be displayed in the table.
	 * @param int $padding The padding to be applied to each column in the table. Defaults to 3.
	 * @param int $headerPadding The padding to be applied to each header int the table. Defaults ti 4.
	 * @return void
	 */
	public function table(array $data, int $padding = 3, int $headerPadding = 9): void
	{
		(new Table($this, $data, $padding, $headerPadding))->render();
	}
}
