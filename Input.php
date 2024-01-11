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
	 * @var array The command line arguments.
	 */
	protected array $arguments = [];

	/**
	 * {@inheritdoc}
	 */
	public function getArguments(): mixed
	{
		$this->extractArguments();

		return $this->arguments;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getArgument(string $name, mixed $default = null): mixed
	{
		$this->extractArguments();

		return $this->arguments[$name] ?? $default;
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

	/**
	 * Extract the arguments from the console.
	 *
	 * @return void
	 */
	protected function extractArguments(): void
	{
		if (!empty($this->arguments)) {
			return;
		}

		$arguments = array_splice($_SERVER['argv'], 2);

		foreach ($arguments as $argument) {
			if (!str_starts_with($argument, '-')) {
				continue;
			}

			$options = explode('=', $argument);
			$name = preg_replace('/^(--|-)/', '', $options[0], 1);
			$params[$name] = $options[1] ?? true;
		}

		$this->arguments = $params ?? [];
	}
}
