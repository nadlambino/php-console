<?php

declare(strict_types=1);

namespace Inspira\Console\Commands;

use Closure;
use Inspira\Console\Contracts\CommandRegistryInterface;
use Inspira\Console\Exceptions\DuplicateCommandException;
use ReflectionClass;
use Throwable;
use function Inspira\Utils\trimplode;

/**
 * Class Registry
 * Manages and stores registered console commands.
 *
 * @package Inspira\Console\Commands
 */
class Registry implements CommandRegistryInterface
{
    /**
     * The array of registered commands.
     *
     * @var array
     */
    protected array $commands = [];

    /**
     * {@inheritdoc}
     * @throws DuplicateCommandException
     */
    public function addCommand(string $name, Closure | string $command) : static
    {
        if (isset($this->commands[$name])) {
            throw new DuplicateCommandException("Command name [$name] has already been used.");
        }

        $this->commands[$name] = $command;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function has(string $name) : bool
    {
        return isset($this->commands[$name]);
    }

    /**
     * {@inheritdoc}
     */
    public function getCommand(string $name) : Closure | string | null
    {
        return $this->commands[$name] ?? null;
    }

    /**
     * {@inheritdoc}
     */
    public function getAllCommands() : array
    {
        return $this->commands;
    }

    /**
     * Get detailed information about all registered commands.
     *
     * @return array The array of detailed command information.
     */
    public function getDetailedCommands() : array
    {
        foreach ($this->commands as $name => $command) {
            $commands[] = [
                'command' => $name,
                ...$this->getProperties($command),
            ];
        }

        $commands = $commands ?? [];
        sort($commands);

        return $commands;
    }

    /**
     * Get properties (description, requires, optionals) of a command.
     *
     * @param Closure|string $command The class or closure representing the command.
     *
     * @return array The array of command properties.
     */
    protected function getProperties(Closure | string $command) : array
    {
        $default = [
            'description' => '-',
            'argument' => '-',
            'options' => '-',
        ];

        if ($command instanceof Closure) {
            return $default;
        }

        try {
            $reflection = new ReflectionClass($command);
            $description = $reflection->getProperty('description');
            $argument = $reflection->getProperty('argument');
            $options = $reflection->getProperty('options');

            return [
                'description' => empty($value = $description->getDefaultValue()) ? '-' : $value,
                'argument' => ($value = $argument->getDefaultValue()) === null ? '-' : $value,
                'options' => empty($value = trimplode(', ', $options->getDefaultValue())) ? '-' : $value,
            ];
        } catch (Throwable) {
            return $default;
        }
    }
}
