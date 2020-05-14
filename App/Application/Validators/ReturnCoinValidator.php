<?php

namespace App\Application\Validators;

use App\Application\Exceptions\InvalidCoinException;
use App\Domain\VendingMachine\Enums\Coin;

class ReturnCoinValidator implements Validator
{
	private static $validCoins = [
		Coin::FIVE_CENTS,
		Coin::TEN_CENTS,
		Coin::TWENTYFIVE_CENTS,
		Coin::ONE_EURO
	];

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