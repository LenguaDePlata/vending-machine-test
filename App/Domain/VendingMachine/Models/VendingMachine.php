<?php

namespace App\Domain\VendingMachine\Models;

use App\Domain\VendingMachine\Enums\Coin;
use App\Domain\VendingMachine\Enums\Item;

class VendingMachine
{
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
		$this->stock[Item::WATER] = $waterItems;
		$this->stock[Item::SODA] = $sodaItems;
		$this->stock[Item::JUICE] = $juiceItems;
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

	protected function addToInsertedCoins(string $typeOfCoin, int $coinsToAdd): void
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

	public function getItem(string $itemName): array
	{
		return [
			Coin::FIVE_CENTS => 0,
			Coin::TEN_CENTS => 0,
			Coin::TWENTYFIVE_CENTS => 0,
			Coin::ONE_EURO => 0
		];
	}
}