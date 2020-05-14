<?php

namespace App\Domain\VendingMachine\ValueObjects;

class Change
{
	private $fiveCentCoins;
	private $tenCentCoins;
	private $twentyfiveCentCoins;
	private $oneEuroCoins;

	public function __construct(int $fiveCentCoins,
								int $tenCentCoins,
								int $twentyfiveCentCoins,
								int $oneEuroCoins = 0)
	{
		$this->fiveCentCoins = $fiveCentCoins;
		$this->tenCentCoins = $tenCentCoins;
		$this->twentyfiveCentCoins = $twentyfiveCentCoins;
		$this->oneEuroCoins = $oneEuroCoins;
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

	public function getOneEuroCoins(): int
	{
		return $this->oneEuroCoins;
	}
}