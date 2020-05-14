<?php

namespace App\Application\Services;

use App\Domain\VendingMachine\ValueObjects\Change;

class CoinCounter
{
	private const FIVE_CENTS = '0.05';
	private const TEN_CENTS = '0.10';
	private const TWENTYFIVE_CENTS = '0.25';
	private const ONE_EURO = '1';

	public function __invoke(array $coins): Change
	{
		$totalCoins = [
			self::FIVE_CENTS => 0,
			self::TEN_CENTS => 0,
			self::TWENTYFIVE_CENTS => 0,
			self::ONE_EURO => 0
		];

		foreach ($coins as $value) {
			$totalCoins[$value]++;
		}

		return new Change(
			$totalCoins[self::FIVE_CENTS],
			$totalCoins[self::TEN_CENTS],
			$totalCoins[self::TWENTYFIVE_CENTS],
			$totalCoins[self::ONE_EURO]
		);
	}
}