<?php

declare(strict_types=1);

namespace Inspira\Console\Commands;

use Inspira\Console\Contracts\CommandInterface;
use Inspira\Console\Contracts\InputInterface;
use Inspira\Console\Contracts\OutputInterface;

/**
 * Class Command
 *
 * Abstract base class for console commands.
 *
 * @package Inspira\Console\Commands
 */
abstract class Command implements CommandInterface
{
	/**
	 * @var string The description of the command.
	 */
	protected string $description = '';

	/**
	 * @var ?string The argument for the command.
	 */
	protected ?string $argument = null;

	/**
	 * @var array The options for the command.
	 */
	protected array $options = [];

	/**
	 * Command constructor.
	 *
	 * @param InputInterface $input The input instance for handling command input.
	 * @param OutputInterface $output The output instance for displaying command output.
	 */
	public function __construct(protected InputInterface $input, protected OutputInterface $output)
	{
	}
}
