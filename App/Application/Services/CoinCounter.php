<?php

namespace App\Application\Services;

use App\Domain\VendingMachine\ValueObjects\Change;
use App\Domain\VendingMachine\Enums\Coin;

class CoinCounter
{
	public function __invoke(array $coins): Change
	{
		$totalCoins = [
			Coin::FIVE_CENTS => 0,
			Coin::TEN_CENTS => 0,
			Coin::TWENTYFIVE_CENTS => 0,
			Coin::ONE_EURO => 0
		];

		foreach ($coins as $value) {
			$totalCoins[$value]++;
		}

		return new Change(
			$totalCoins[Coin::FIVE_CENTS],
			$totalCoins[Coin::TEN_CENTS],
			$totalCoins[Coin::TWENTYFIVE_CENTS],
			$totalCoins[Coin::ONE_EURO]
		);
	}
}