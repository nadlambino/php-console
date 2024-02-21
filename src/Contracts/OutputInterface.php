<?php

declare(strict_types=1);

namespace Inspira\Console\Contracts;

use Inspira\Console\Enums\Color;

/**
 * Interface OutputInterface
 *
 * Handles console output and formatting.
 *
 * @package Inspira\Console\Contracts
 */
interface OutputInterface
{
	/**
	 * Display a success message with optional exit.
	 *
	 * @param string $message The success message.
	 * @param bool $exit Whether to exit after displaying the message.
	 *
	 * @return void
	 */
	public function success(string $message, bool $exit = true): void;

	/**
	 * Display an info message with optional exit.
	 *
	 * @param string $message The info message.
	 * @param bool $exit Whether to exit after displaying the message.
	 *
	 * @return void
	 */
	public function info(string $message, bool $exit = true): void;

	/**
	 * Display a warning message with optional exit.
	 *
	 * @param string $message The warning message.
	 * @param bool $exit Whether to exit after displaying the message.
	 *
	 * @return void
	 */
	public function warning(string $message, bool $exit = true): void;

	/**
	 * Display an error message with optional exit.
	 *
	 * @param string $message The error message.
	 * @param bool $exit Whether to exit after displaying the message.
	 *
	 * @return void
	 */
	public function error(string $message, bool $exit = true): void;

	/**
	 * Write text to the output stream.
	 *
	 * @param string $text The text to be written.
	 *
	 * @return $this
	 */
	public function write(string $text): self;

	/**
	 * Write a line of text to the output stream with a newline character.
	 *
	 * @param string $text The text to be written.
	 *
	 * @return static
	 */
	public function writeln(string $text): static;

	/**
	 * Write a newline character to the output stream.
	 *
	 * @return $this
	 */
	public function newln(): self;

	/**
	 * Clear the console screen and reposition the cursor to top left.
	 *
	 * @return static
	 */
	public function clear(): static;

	/**
	 * Apply ANSI color to a message.
	 *
	 * @param string $message The message to colorize.
	 * @param Color|int|array $color The ANSI color code.
	 * @param bool $isBright Whether to use ANSI bright color.
	 *
	 * @return string The colorized message.
	 */
	public function colorize(string $message, Color|int|array $color, bool $isBright = false): string;

	/**
	 * Display a table in the console.
	 *
	 * @param array $data The tabular data to be displayed in the table.
	 * @param string $caption The table caption.
	 * @param int $padding The padding to be applied to each column in the table. Defaults to 3.
	 * @param int $headerPadding The padding to be applied to each header int the table. Defaults to 4.
	 *
	 * @return void
	 */
	public function table(array $data, string $caption = '', int $padding = 3, int $headerPadding = 9): void;
}
