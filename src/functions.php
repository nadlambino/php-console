<?php

if (!function_exists('strlen_ansi_escaped')) {
	function strlen_ansi_escaped(string $string): int
	{
		$string = preg_replace('/\\033\[[\d;]*m/', '', $string);

		return mb_strlen($string) ?: 0;
	}
}
