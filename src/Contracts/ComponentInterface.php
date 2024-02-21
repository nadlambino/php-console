<?php

declare(strict_types=1);

namespace Inspira\Console\Contracts;

/**
 * Interface ComponentInterface
 *
 * This interface defines the contract for console components that can be rendered.
 *
 * @package Inspira\Console\Contracts
 */
interface ComponentInterface
{
	/**
	 * Render the console component.
	 *
	 * Implementing classes should provide the logic for rendering the component.
	 * This method is responsible for outputting the content of the component to the console.
	 *
	 * @return void
	 */
	public function render(): void;
}
