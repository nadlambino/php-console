<?php

declare(strict_types=1);

namespace Inspira\Console\Commands;

use Closure;
use Inspira\Console\Contracts\CommandRegistryInterface;
use Inspira\Console\Contracts\CommandResolverInterface;
use Inspira\Console\Exceptions\MissingCommandException;
use Inspira\Console\Exceptions\MissingArgumentException;
use Inspira\Console\Exceptions\UnregisteredCommandException;
use Inspira\Console\Exceptions\UnresolvableCommandException;
use Inspira\Console\Input;
use Psr\Container\ContainerInterface;
use ReflectionClass;
use Throwable;

/**
 * Class CommandResolver
 *
 * Resolves and executes console commands.
 *
 * @package Inspira\Console\Commands
 */
class CommandResolver implements CommandResolverInterface
{
	/**
	 * The name of the command.
	 *
	 * @var string
	 */
	protected string $name;

	/**
	 * The command to be resolved and executed.
	 *
	 * @var Closure|string
	 */
	protected Closure|string $command;

	/**
	 * CommandResolver constructor.
	 *
	 * @param ContainerInterface $container The container instance for dependency injection.
	 * @param CommandRegistryInterface $commandRegistry The command registry for managing registered commands.
	 * @param Input $input The input instance for handling command input.
	 *
	 * @throws MissingCommandException
	 * @throws UnregisteredCommandException
	 */
	public function __construct(
		protected ContainerInterface       $container,
		protected CommandRegistryInterface $commandRegistry,
		protected Input                    $input
	)
	{
		$this->validate();
	}

	/**
	 * {@inheritdoc}
	 */
	public function resolve(): void
	{
		if ($this->command instanceof Closure || is_callable($this->command)) {
			$this->container->resolve($this->command);
			exit(0);
		}

		$this->validateArguments();

		// Resolve the command's 'run' method.
		$this->container->resolve($this->command, 'run');
	}

	/**
	 * Validate and resolve command arguments.
	 *
	 * @throws UnresolvableCommandException
	 */
	protected function validateArguments(): void
	{
		try {
			$reflection = new ReflectionClass($this->command);
			$properties = $reflection->getProperty('requires');
			$requires = $properties->getDefaultValue() ?? [];
			$parameterNames = array_keys($this->input->getArguments());

			if (!empty($requires) && $missing = array_diff($requires, $parameterNames)) {
				$names = trimplode(', ', array_map(fn($values) => '"' . $values . '"', $missing));
				$label = count($missing) <= 1 ? 'parameter' : 'parameters';
				throw new MissingArgumentException("Missing required $label: [$names]");
			}
		} catch (Throwable $exception) {
			if ($exception instanceof MissingArgumentException) {
				throw $exception;
			}

			throw new UnresolvableCommandException("Unable to resolve [$this->name] command.");
		}
	}

	/**
	 * Validate the command and its name.
	 *
	 * @throws MissingCommandException
	 * @throws UnregisteredCommandException
	 */
	protected function validate(): void
	{
		$this->name = $this->input->getCommand();

		if (empty($this->name)) {
			throw new MissingCommandException("Missing command name.");
		}

		$command = $this->commandRegistry->getCommand($this->name);

		if (empty($command)) {
			throw new UnregisteredCommandException("Unknown command [$this->name]. Did you register this command?");
		}

		$this->command = $command;
	}
}
