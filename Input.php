<?php

declare(strict_types=1);

namespace Inspira\Console;

use Closure;
use Throwable;
use ReflectionClass;

class Input
{
	protected array $commands = [];

	protected array $arguments = [];

	public function addCommand(string $name, string|Closure $command): void
	{
		$this->commands[$name] = $command;
	}

	public function getCommands(?string $name = null): mixed
	{
		if (!isset($name)) {
			return $this->commands;
		}

		return $this->commands[$name] ?? null;
	}

	public function getArguments(?string $name = null, mixed $default = null): mixed
	{
		if (empty($name)) {
			return $this->arguments;
		}

		return $this->arguments[$name] ?? $default;
	}

	public function getCommandName(): ?string
	{
		return $_SERVER['argv'][1] ?? null;
	}

	public function setArguments(): void
	{
		$arguments = array_splice($_SERVER['argv'], 2);

		foreach ($arguments as $argument) {
			$opt = explode('=', $argument);
			$options[$opt[0]] = $opt[1] ?? true;
		}

		$this->arguments = $options ?? [];
	}

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
