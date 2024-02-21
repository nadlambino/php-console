<?php

declare(strict_types=1);

namespace Inspira\Console\Contracts;

/**
 * Interface SpacingInterface
 *
 * Interface providing methods for text spacing customization.
 * This interface is intended to be implemented by classes that need text spacing capabilities.
 */
interface SpacingInterface
{
	/**
	 * Add padding to the left side of the text.
	 *
	 * @param int $padding The number of spaces to add to the left side of the text.
	 *
	 * @return static
	 */
	public function paddingLeft(int $padding): static;

	/**
	 * Add padding to the right side of the text.
	 *
	 * @param int $padding The number of spaces to add to the right side of the text.
	 *
	 * @return static
	 */
	public function paddingRight(int $padding): static;

	/**
	 * Add padding to both sides of the text.
	 *
	 * @param int $padding The number of spaces to add to both sides of the text.
	 *
	 * @return static
	 */
	public function paddingX(int $padding): static;

	/**
	 * Add padding to the top of the text.
	 *
	 * @param int $padding The number of empty lines to add to the top of the text.
	 *
	 * @return static
	 */
	public function paddingTop(int $padding): static;

	/**
	 * Add padding to the bottom of the text.
	 *
	 * @param int $padding The number of empty lines to add to the bottom of the text.
	 *
	 * @return static
	 */
	public function paddingBottom(int $padding): static;

	/**
	 * Add padding to both the top and bottom of the text.
	 *
	 * @param int $padding The number of empty lines to add to both the top and bottom of the text.
	 *
	 * @return static
	 */
	public function paddingY(int $padding): static;
}
