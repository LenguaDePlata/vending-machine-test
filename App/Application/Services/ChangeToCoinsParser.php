<?php

namespace App\Application\Services;

use App\Domain\VendingMachine\ValueObjects\Change;
use App\Domain\VendingMachine\Enums\Coin;

class ChangeToCoinsParser
{
	private const SEPARATOR = ', ';

	public function __invoke(Change $change): string
	{
		$fiveCentCoins = array_fill(
			0, 
			$change->getFiveCentCoins(), 
			Coin::FIVE_CENTS
		);
		$tenCentCoins = array_fill(
			0, 
			$change->getTenCentCoins(), 
			Coin::TEN_CENTS
		);
		$twentyfiveCentCoins = array_fill(
			0, 
			$change->getTwentyFiveCentCoins(), 
			Coin::TWENTYFIVE_CENTS
		);
		$oneEuroCoins = array_fill(
			0, 
			$change->getOneEuroCoins(), 
			Coin::ONE_EURO
		);

		$coinString = implode(
			self::SEPARATOR, 
			array_merge(
				$fiveCentCoins, 
				$tenCentCoins, 
				$twentyfiveCentCoins, 
				$oneEuroCoins
			)
		);
		return $coinString;
	}
}