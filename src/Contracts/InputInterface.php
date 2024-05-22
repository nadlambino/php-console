<?php

declare(strict_types=1);

namespace Inspira\Console\Contracts;

/**
 * Interface InputInterface
 *
 * Defines the contract for handling console input and commands.
 *
 * @package Inspira\Console
 */
interface InputInterface
{
	/**
	 * Get all the options from the command that is being run.
	 *
	 * @return array The array of options.
	 */
	public function getOptions(): array;

	/**
	 * Get a specific option from the command that is being run.
	 *
	 * @param string $name The name of the option.
	 * @param mixed $default The default value of the option.
	 * 
	 * @return mixed The value of specific option.
	 */
	public function getOption(string $name, mixed $default = null): mixed;

	/**
	 * Get the argument from the command that is being run.
	 *
	 * @return mixed The value of the argument.
	 */
	public function getArgument(): mixed;

	/**
	 * Get the name of the command that is being run.
	 *
	 * @return string|null The name of the console command.
	 */
	public function getCommand(): ?string;

	/**
	 * Check if there is a command to run.
	 *
	 * @return bool
	 */
	public function hasCommand(): bool;
}
