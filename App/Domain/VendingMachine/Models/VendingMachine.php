<?php

namespace App\Domain\VendingMachine\Models;

use App\Domain\VendingMachine\Enums\Coin;
use App\Domain\VendingMachine\Enums\Item;
use App\Domain\VendingMachine\Services\CoinArrayAdder;
use App\Domain\VendingMachine\Exceptions\NotEnoughInsertedCoinsException;
use App\Domain\VendingMachine\Exceptions\NotEnoughChangeException;
use App\Domain\VendingMachine\Exceptions\NotEnoughStockException;

class VendingMachine
{
	private static $instance = null;
	private static $itemPrices = [
		Item::WATER => 0.65,
		Item::SODA => 1.00,
		Item::JUICE => 1.50
	];

	private $change = [];
	private $stock = [];
	private $insertedCoins = [];

	private $coinArrayAdder;

	private function __clone(){}

	public function __construct(CoinArrayAdder $coinArrayAdder)
	{
		$this->coinArrayAdder = $coinArrayAdder;
		$this->stock = [
			Item::WATER => 0,
			Item::SODA => 0,
			Item::JUICE => 0
		];
	}

	public static function getInstance(): self
	{
		if (is_null(static::$instance)) {
			$coinArrayAdder = new CoinArrayAdder();
			self::$instance = new VendingMachine($coinArrayAdder);
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
		$this->checkStock($itemName);
		$this->checkPrice($itemName);
		$this->checkAvailableChange($itemName);

		$this->reduceStock($itemName);
		$this->payItem($itemName);

		return $this->getInsertedCoins();
	}

	protected function checkStock(string $itemName): void
	{
		if ($this->stock[$itemName] == 0) {
			throw new NotEnoughStockException();
		}
	}

	protected function checkPrice(string $itemName): void
	{
		$itemPrice = self::$itemPrices[$itemName];
		$totalInsertedCoinsValue = $this->coinArrayAdder->__invoke($this->insertedCoins);
		echo $totalInsertedCoinsValue.PHP_EOL;
		if ($itemPrice > $totalInsertedCoinsValue) {
			throw new NotEnoughInsertedCoinsException($itemPrice - $totalInsertedCoinsValue);
		}
	}

	protected function checkAvailableChange(string $itemName): void
	{
		$itemPrice = self::$itemPrices[$itemName];
		// $neededChange = $totalInsertedCoinsValue - $itemPrice;
		$totalMachineChangeValue = $this->coinArrayAdder->__invoke($this->change);
		if ($totalMachineChangeValue == 0) {
			throw new NotEnoughChangeException($itemPrice);
		}
	}

	protected function reduceStock(string $itemName): void
	{
		$this->stock[$itemName]--;
	}

	protected function payItem(string $itemName): void
	{

	}
}