<?php

namespace App\Application\UseCases;

use App\Domain\VendingMachine\ValueObjects\Change;
use App\Domain\VendingMachine\Models\VendingMachine;
use App\Domain\VendingMachine\Enums\Coin;

class CoinReturner
{
	public function __invoke(): Change
	{
		$vendingMachine = VendingMachine::getInstance();
		$returnedChange = $vendingMachine->ejectInsertedCoins();
		return new Change(
			$returnedChange[Coin::FIVE_CENTS],
			$returnedChange[Coin::TEN_CENTS],
			$returnedChange[Coin::TWENTYFIVE_CENTS],
			$returnedChange[Coin::ONE_EURO]
		);
	}
}