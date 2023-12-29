<?php

declare(strict_types=1);

namespace Inspira\Console;

abstract class Command implements CommandInterface
{
	protected string $description = '';

	protected array $requires = [];

	protected array $optionals = [];

	public function __construct(protected Input $input, protected Output $output) { }
}
