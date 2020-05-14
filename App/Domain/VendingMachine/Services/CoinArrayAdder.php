<?php

namespace App\Domain\VendingMachine\Services;

class CoinArrayAdder
{
	public function __invoke(array $arrayToSum): float
	{
		$totalSum = 0.0;
		foreach ($arrayToSum as $coinValue => $numberOfCoins) {
			$totalSum += floatVal($coinValue) * $numberOfCoins;
		}
		return $totalSum;
	}
}