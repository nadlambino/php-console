<?php

declare(strict_types=1);

namespace Inspira\Console\Contracts;

use Closure;

/**
 * Interface CommandRegistryInterface
 *
 * Defines the contract for managing and storing console commands.
 *
 * @package Inspira\Console\Contracts
 */
interface CommandRegistryInterface
{
	/**
	 * Add a new console command to the registry.
	 *
	 * @param string $name The name of the command.
	 * @param Closure|string $command The class or closure representing the command.
	 *
	 * @return static
	 */
	public function addCommand(string $name, Closure|string $command): static;

	/**
	 * Get the command associated with the given name.
	 *
	 * @param string $name The name of the command.
	 *
	 * @return Closure|string|null The command or null if not found.
	 */
	public function getCommand(string $name): Closure|string|null;

	/**
	 * Get all registered commands.
	 *
	 * @return array The array of registered commands.
	 */
	public function getAllCommands(): array;

	/**
	 * Check if a command with a given name exists in the registry.
	 *
	 * @param string $name The name of the command.
	 *
	 * @return bool
	 */
	public function has(string $name): bool;
}
