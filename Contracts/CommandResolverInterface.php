<?php

declare(strict_types=1);

namespace Inspira\Console\Contracts;

use Inspira\Console\Exceptions\UnresolvableCommandException;

/**
 * Interface CommandResolverInterface
 *
 * Resolves and executes console commands.
 *
 * @package Inspira\Console\Contracts
 */
interface CommandResolverInterface
{
	/**
	 * Resolve and execute the console command.
	 *
	 * @throws UnresolvableCommandException
	 */
	public function resolve(): void;
}
