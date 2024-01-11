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
	 * Get all the arguments from the command that is being run.
	 *
	 * @return mixed The array of arguments or a specific argument.
	 */
	public function getArguments(): mixed;


	/**
	 * Get the value of the given argument from the command that is being run.
	 *
	 * @param string $name The name of the argument.
	 * @param mixed $default The default value if the argument is not found.
	 *
	 * @return mixed The array of arguments or a specific argument.
	 */
	public function getArgument(string $name, mixed $default = null): mixed;

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
