<?php

declare(strict_types=1);

namespace Inspira\Console;

use Inspira\Console\Contracts\InputInterface;

/**
 * Class Input
 *
 * Handles console input and commands.
 *
 * @package Inspira\Console
 */
class Input implements InputInterface
{
	/**
	 * @var string|null The command line argument.
	 */
	protected ?string $argument = null;

	/**
	 * @var array The command line options.
	 */
	protected array $options = [];

	public function getArgument(): ?string
    {
		$this->extractArgument();

		return $this->argument;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getOptions(): array
	{
		$this->extractOptions();

		return $this->options;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getOption(string $name, mixed $default = null): mixed
	{
		$this->extractOptions();

		return $this->options[$name] ?? $default;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getCommand(): ?string
	{
		return $this->hasCommand() ? $_SERVER['argv'][1] : null;
	}

	/**
	 * {@inheritdoc}
	 */
	public function hasCommand(): bool
	{
		return $_SERVER['argc'] >= 2;
	}

	protected function extractArgument() : void
    {
		if (! empty($this->argument)) {
			return;
		}

		$arguments = array_slice($_SERVER['argv'], 2);
		$argument = $arguments[0] ?? '';

		if (! str_starts_with($argument, '-')) {
			$this->argument = array_shift($arguments);
		}
	}

	/**
	 * Extract the arguments from the console.
	 *
	 * @return void
	 */
	protected function extractOptions(): void
	{
        if (! empty($this->options)) {
            return;
        }

		$args = array_slice($_SERVER['argv'], 2);

		foreach ($args as $arg) {
			if (! str_starts_with($arg, '-')) {
				continue;
			}

			$arguments = explode('=', $arg);
			$name = preg_replace('/^(--|-)/', '', $arguments[0], 1);
			$this->options[$name] = $arguments[1] ?? true;
		}
	}
}
