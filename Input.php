<?php

declare(strict_types=1);

namespace Inspira\Console;

use Closure;
use ReflectionClass;
use Throwable;

/**
 * Class Input
 *
 * Handles console input and commands.
 *
 * @package Inspira\Console
 */
class Input
{
	/**
	 * @var array The registered console commands.
	 */
	protected array $commands = [];

	/**
	 * @var array The command line arguments.
	 */
	protected array $arguments = [];

	/**
	 * Add a console command.
	 *
	 * @param string $name The name of the command.
	 * @param string|Closure $command The class or closure representing the command.
	 *
	 * @return void
	 */
	public function addCommand(string $name, string|Closure $command): void
	{
		$this->commands[$name] = $command;
	}

	/**
	 * Get registered console commands or a specific command by name.
	 *
	 * @param string|null $name The name of the command.
	 *
	 * @return mixed The array of commands or a specific command.
	 */
	public function getCommands(?string $name = null): mixed
	{
		if (!isset($name)) {
			return $this->commands;
		}

		return $this->commands[$name] ?? null;
	}

	/**
	 * Get command line arguments or a specific argument by name.
	 *
	 * @param string|null $name The name of the argument.
	 * @param mixed $default The default value if the argument is not found.
	 *
	 * @return mixed The array of arguments or a specific argument.
	 */
	public function getArguments(?string $name = null, mixed $default = null): mixed
	{
		if (empty($name)) {
			return $this->arguments;
		}

		return $this->arguments[$name] ?? $default;
	}

	/**
	 * Get the name of the console command from the command line.
	 *
	 * @return string|null The name of the console command.
	 */
	public function getCommandName(): ?string
	{
		return $_SERVER['argv'][1] ?? null;
	}

	/**
	 * Set command line arguments from the command line.
	 *
	 * @return void
	 */
	public function setArguments(): void
	{
		$arguments = array_splice($_SERVER['argv'], 2);

		foreach ($arguments as $argument) {
			$opt = explode('=', $argument);
			$options[$opt[0]] = $opt[1] ?? true;
		}

		$this->arguments = $options ?? [];
	}

	/**
	 * Get properties of a console command.
	 *
	 * @param string|Closure $implementation The class or closure representing the command.
	 *
	 * @return array The properties of the console command.
	 */
	public function getCommandProperties(string|Closure $implementation): array
	{
		$default = [
			'description' => '-',
			'requires' => '-',
			'optionals' => '-',
		];

		if ($implementation instanceof Closure) {
			return $default;
		}

		try {
			$reflection = new ReflectionClass($implementation);
			$description = $reflection->getProperty('description');
			$requires = $reflection->getProperty('requires');
			$optionals = $reflection->getProperty('optionals');

			return [
				'description' => $description->getDefaultValue(),
				'requires' => trimplode(', ', $requires->getDefaultValue()),
				'optionals' => trimplode(', ', $optionals->getDefaultValue()),
			];
		} catch (Throwable) {
			return $default;
		}
	}
}
