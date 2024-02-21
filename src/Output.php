<?php

declare(strict_types=1);

namespace Inspira\Console;

use Inspira\Console\Components\Table;
use Inspira\Console\Contracts\OutputInterface;
use Inspira\Console\Contracts\StylesInterface;
use Inspira\Console\Enums\Color;
use Inspira\Console\Styles\Styles;

/**
 * Class Output
 *
 * Handles console output and formatting.
 *
 * @package Inspira\Console
 */
class Output implements OutputInterface
{
	/**
	 * Clear screen and cursor reposition ANSI codes.
	 */
	protected const CLEAR_SCREEN = "\033[2J\033[H";

	/**
	 * Class constructor for the Output class.
	 *
	 * This constructor initializes the Output instance with an optional stream.
	 * If the provided stream is not a valid resource, it defaults to STDOUT (standard output).
	 *
	 * @param resource|null $stream An optional stream resource for output. Defaults to STDOUT if not provided or invalid.
	 */
	public function __construct(protected mixed $stream = null, public ?StylesInterface $styles = null)
	{
		if (!is_resource($this->stream)) {
			$this->stream = STDOUT;
		}

		$this->styles ??= new Styles();
	}

	/**
	 * {@inheritdoc}
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
	 * {@inheritdoc}
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
	 * {@inheritdoc}
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
	 * {@inheritdoc}
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
	 * {@inheritdoc}
	 */
	public function write(string $text): self
	{
		fwrite($this->stream, $text);

		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function writeln(string $text): static
	{
		fwrite($this->stream, $text . PHP_EOL);

		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function newln(): self
	{
		fwrite($this->stream, PHP_EOL);

		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function clear(): static
	{
		$this->writeln(self::CLEAR_SCREEN);

		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function colorize(string $message, Color|int|array $color, bool $isBright = false): string
	{
		return $this->styles->reset()->fgColorize($color, $isBright)->apply($message);
	}

	/**
	 * {@inheritdoc}
	 */
	public function table(array $data, string $caption = '', int $padding = 3, int $headerPadding = 9): void
	{
		(new Table($this, $data, $padding, $headerPadding))->caption($caption, 2)->render();
	}
}
