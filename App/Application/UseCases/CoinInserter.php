<?php

namespace App\Application\UseCases;

use App\Domain\VendingMachine\ValueObjects\Change;
use App\Domain\VendingMachine\Models\VendingMachine;

class CoinInserter
{
	public function __invoke(Change $insertedChange): void
	{
		$vendingMachine = VendingMachine::getInstance();
		$vendingMachine->insertCoins(
			$insertedChange->getFiveCentCoins(),
			$insertedChange->getTenCentCoins(),
			$insertedChange->getTwentyFiveCentCoins(),
			$insertedChange->getOneEuroCoins()
		);
	}
}