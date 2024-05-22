<?php

declare(strict_types=1);

namespace Inspira\Console;

use Closure;
use Inspira\Console\Commands\Resolver;
use Inspira\Console\Contracts\CommandRegistryInterface;
use Inspira\Console\Contracts\InputInterface;
use Inspira\Console\Contracts\OutputInterface;
use JetBrains\PhpStorm\NoReturn;
use Psr\Container\ContainerInterface;
use Throwable;

/**
 * Class Console
 * The main class for handling console commands.
 *
 * @package Inspira\Console
 */
class Console
{
    /**
     * Console constructor.
     *
     * @param ContainerInterface       $container The container instance for dependency injection.
     * @param Input                    $input     The input instance for handling command input.
     * @param OutputInterface          $output    The output instance for displaying command output.
     * @param CommandRegistryInterface $registry  The command registry for managing registered commands.
     */
    public function __construct(
        protected ContainerInterface       $container,
        protected InputInterface           $input,
        protected OutputInterface          $output,
        protected CommandRegistryInterface $registry,
    )
    {
    }

    /**
     * Register a console command.
     *
     * @param string         $name    The name of the command.
     * @param string|Closure $command The class or closure representing the command.
     *
     * @return $this
     */
    public function addCommand(string $name, string | Closure $command) : static
    {
        $this->registry->addCommand($name, $command);

        return $this;
    }

    /**
     * Clear the console screen.
     *
     * @return static
     */
    public function clear() : static
    {
        $this->output->clear();

        return $this;
    }

    /**
     * Run the console application.
     *
     * @return void
     */
    public function run() : void
    {
        try {
            if (! $this->input->hasCommand()) {
                $this->showAllDetailedCommands();
            }

            (new Resolver($this->container, $this->registry, $this->input))->resolve();
        } catch (Throwable $exception) {
            $this->output->error($exception->getMessage());
        }
    }

    /**
     * Show all available commands in detailed form.
     *
     * @return void
     */
    #[NoReturn]
    protected function showAllDetailedCommands() : void
    {
        $commands = $this->registry->getDetailedCommands();

        if (empty($commands)) {
            $this->output->info("No available commands.");
        }

        $this->output->table($commands, "Available Commands", 7);

        exit(0);
    }
}
