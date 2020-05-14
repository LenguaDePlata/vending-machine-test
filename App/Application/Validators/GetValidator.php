<?php

namespace App\Application\Validators;

use App\Application\Exceptions\InvalidCoinException;
use App\Application\Exceptions\InvalidItemException;
use App\Domain\VendingMachine\Enums\Coin;
use App\Domain\VendingMachine\Enums\Item;

class GetValidator implements Validator
{
	private static $validCoins = [
		Coin::FIVE_CENTS,
		Coin::TEN_CENTS,
		Coin::TWENTYFIVE_CENTS,
		Coin::ONE_EURO
	];

	private static $validItems = [
		Item::WATER,
		Item::SODA,
		Item::JUICE
	];

	public function validate(array $arguments): void
	{
		$commandName = array_pop($arguments);
		$commandArray = explode('-', $commandName);
		$itemName = array_pop($commandArray);

		$validCoinsRegexString = str_replace('.', '\.', implode('|', self::$validCoins));
		foreach ($arguments as $argument) {
			if (!preg_match('/^'.$validCoinsRegexString.'$/', $argument)) {
				throw new InvalidCoinException($argument, self::$validCoins);
			}
		}

		$validItemsRegexString = implode('|', self::$validItems);
		if (!preg_match('/^'.$validItemsRegexString.'$/', $itemName)) {
			throw new InvalidItemException($itemName, self::$validItems);
		}
	}
}