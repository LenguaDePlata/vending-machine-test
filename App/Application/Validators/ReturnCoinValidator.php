<?php

namespace App\Application\Validators;

class ReturnCoinValidator implements Validator
{
	private static $validCoins = ['0.05', '0.10', '0.25', '1'];

	public function validate(array $arguments): void
	{
		$validCoinsRegexString = str_replace('.', '\.', implode('|', self::$validCoins));
		foreach ($arguments as $argument) {
			if (!preg_match('/^'.$validCoinsRegexString.'$/', $argument)) {
				throw new InvalidCoinException($argument, self::$validCoins);
			}
		}
	}
}