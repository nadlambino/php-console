<?php

declare(strict_types=1);

namespace Inspira\Console\Contracts;

interface ComponentInterface
{
	public function render(): void;
}
