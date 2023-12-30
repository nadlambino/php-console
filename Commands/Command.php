<?php

declare(strict_types=1);

namespace Inspira\Console\Commands;

use Inspira\Console\Input;
use Inspira\Console\Output;

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
	 * @var array The required parameters for the command.
	 */
	protected array $requires = [];

	/**
	 * @var array The optional parameters for the command.
	 */
	protected array $optionals = [];

	/**
	 * Command constructor.
	 *
	 * @param Input $input The input instance for handling command input.
	 * @param Output $output The output instance for displaying command output.
	 */
	public function __construct(protected Input $input, protected Output $output)
	{
	}
}
