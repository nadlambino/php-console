<?php

declare(strict_types=1);

namespace Inspira\Console;

use Closure;
use Throwable;
use ReflectionClass;
use Inspira\Container\Container;

class Console
{
	public function __construct(public Container $container, protected Input $input, protected Output $output) { }

	public function command(string $name, string|Closure $command): static
	{
		$this->input->addCommand($name, $command);

		return $this;
	}

	public function run(): void
	{
		$this->validateCommand();
		$this->input->setArguments();
		$arguments = $this->input->getArguments();
		$name = $this->input->getCommandName();
		$command = $this->input->getCommands($name);

		if (empty($command)) {
			$this->output->error('Unknown command "' . $name . '". Did you register this command?');
		}

		// This will handle commands that were registered as closure
		// It will automatically exit the console when it is successfully run
		$this->handleClosure($command);

		// Validate required parameters for class command
		$this->validateRequires($command, $arguments);

		try {
			// This will handle commands that were registered as class
			$reflection = new ReflectionClass($command);

			if (!$reflection->implementsInterface(CommandInterface::class)) {
				$this->output->error('Command must be an instance of "' . CommandInterface::class . '"');
			}

			$this->container->resolve($command, 'run');
		} catch (Throwable $exception) {
			$this->output->error($exception->getMessage());
		}
	}

	private function handleClosure(Closure|string $class): void
	{
		if ($class instanceof Closure || is_callable($class)) {
			$this->container->resolve($class);
			exit(0);
		}
	}

	private function getAllAvailableCommands(): array
	{
		foreach ($this->input->getCommands() as $name => $implementation) {
			$command['command'] = $name;
			$command = array_merge($command, $this->input->getCommandProperties($implementation));
			$commands[] = $command;
		}

		return $commands ?? [];
	}

	private function validateCommand(): void
	{
		if (is_null($this->input->getCommandName())) {
			$this->output->info('Inspira\'s available commands', false);
			$this->output->table($this->getAllAvailableCommands(), 27);
			exit();
		}
	}

	private function validateRequires(string $command, array $parameters): void
	{
		try {
			$reflection = new ReflectionClass($command);
			$properties = $reflection->getProperty('requires');
			$requires = $properties->getDefaultValue() ?? [];
			$parameterNames = array_keys($parameters);

			if (!empty($requires) && $missing = array_diff($requires, $parameterNames)) {
				$names = trimplode(', ', array_map(fn($values) => '"' . $values . '"', $missing));
				$label = count($missing) <= 1 ? 'parameter' : 'parameters';
				$this->output->error("Missing required $label $names");
			}
		} catch (Throwable $exception) {
			$this->output->error($exception->getMessage());
		}
	}
}
