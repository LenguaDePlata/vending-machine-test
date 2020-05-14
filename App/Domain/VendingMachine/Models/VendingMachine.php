<?php

namespace App\Domain\VendingMachine\Models;

use App\Domain\VendingMachine\Enums\Coin;

class VendingMachine
{
	private const FIVE_CENT_COINS = 0;
	private const TEN_CENT_COINS = 1;
	private const TWENTYFIVE_CENT_COINS = 2;
	private const ONE_EURO_COINS = 3;

	private const WATER_ITEMS = 0;
	private const SODA_ITEMS = 1;
	private const JUICE_ITEMS = 2;

	private static $instance = null;

	private $change = [];
	private $stock = [];
	private $insertedCoins = [];

	private function __clone(){}

	public static function getInstance(): self
	{
		if (is_null(static::$instance)) {
			self::$instance = new VendingMachine();
		}

		return self::$instance;
	}

	public function setChange(int $fiveCentCoins, 
								int $tenCentCoins, 
								int $twentyfiveCentCoins): void
	{
		$this->change[Coin::FIVE_CENTS] = $fiveCentCoins;
		$this->change[Coin::TEN_CENTS] = $tenCentCoins;
		$this->change[Coin::TWENTYFIVE_CENTS] = $twentyfiveCentCoins;
		$this->change[Coin::ONE_EURO] = 0;
	}

	public function setStock(int $waterItems,
								int $sodaItems,
								int $juiceItems): void
	{
		$this->stock[self::WATER_ITEMS] = $waterItems;
		$this->stock[self::SODA_ITEMS] = $sodaItems;
		$this->stock[self::JUICE_ITEMS] = $juiceItems;
	}

	public function insertCoins(int $fiveCentCoins, 
								int $tenCentCoins, 
								int $twentyfiveCentCoins,
								int $oneEuroCoins): void
	{
		$this->addToInsertedCoins(Coin::FIVE_CENTS, $fiveCentCoins);
		$this->addToInsertedCoins(Coin::TEN_CENTS, $tenCentCoins);
		$this->addToInsertedCoins(Coin::TWENTYFIVE_CENTS, $twentyfiveCentCoins);
		$this->addToInsertedCoins(Coin::ONE_EURO, $oneEuroCoins);
	}

	protected function addToInsertedCoins(int $typeOfCoin, int $coinsToAdd): void
	{
		if (!isset($this->insertedCoins[$typeOfCoin])) {
			$this->insertedCoins[$typeOfCoin] = 0;
		}
		$this->insertedCoins[$typeOfCoin] += $coinsToAdd;
	}

	public function getInsertedCoins(): array
	{
		return $this->insertedCoins;
	}
}