<?php

namespace App\Domain\VendingMachine\ValueObjects;

class Change
{
	private $fiveCentCoins;
	private $tenCentCoins;
	private $twentyfiveCentCoins;

	public function __construct(int $fiveCentCoins,
								int $tenCentCoins,
								int $twentyfiveCentCoins)
	{
		$this->fiveCentCoins = $fiveCentCoins;
		$this->tenCentCoins = $tenCentCoins;
		$this->twentyfiveCentCoins = $twentyfiveCentCoins;
	}

	public function getFiveCentCoins(): int
	{
		return $this->fiveCentCoins;
	}

	public function getTenCentCoins(): int
	{
		return $this->tenCentCoins;
	}

	public function getTwentyFiveCentCoins(): int
	{
		return $this->twentyfiveCentCoins;
	}
}