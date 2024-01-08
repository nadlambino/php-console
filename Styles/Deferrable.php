<?php

declare(strict_types=1);

namespace Inspira\Console\Styles;

use RuntimeException;

/**
 * Trait Deferrable
 *
 * Trait providing deferred method execution functionality.
 */
trait Deferrable
{
	/**
	 * @var array Array to store deferred method details (method name and arguments).
	 */
	private array $deferredMethods = [];

	/**
	 * Run all deferred methods stored in the deferredMethods array.
	 *
	 * @return static Returns an instance of the class for method chaining.
	 *
	 * @throws RuntimeException If any deferred methods fail to execute properly.
	 */
	protected function runDeferredMethods(): static
	{
		$deferred = $this->deferredMethods;
		foreach ($deferred as $key => $details) {
			$method = $details['method'];
			$args = $details['args'];

			$this->$method(...$args);
			unset($this->deferredMethods[$key]);
		}

		if (!empty($this->deferredMethods)) {
			$methods = array_column($this->deferredMethods, 'method');
			$methods = array_map(fn($method) => "'$method'", $methods);
			$stringifyMethods = implode(', ', $methods);

			throw new RuntimeException("The following methods did not run properly. [$stringifyMethods]");
		}

		return $this;
	}

	/**
	 * Defer the execution of a method with its arguments for later execution.
	 *
	 * @param array $args The arguments to be passed to the deferred method.
	 *
	 * @return static Returns an instance of the class for method chaining.
	 */
	protected function defer(array $args = []): static
	{
		$trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);
		$details = $trace[1] ?? [];

		if (empty($details) || !isset($details['function']) || !method_exists($this, $method = $details['function'])) {
			return $this;
		}

		$this->deferredMethods[] = compact('method', 'args');

		return $this;
	}
}
