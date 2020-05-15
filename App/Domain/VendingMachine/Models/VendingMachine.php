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

	private function addToInsertedCoins(string $typeOfCoin, int $coinsToAdd): void
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

	private function checkStock(string $itemName): void
	{
		if ($this->stock[$itemName] == 0) {
			throw new NotEnoughStockException();
		}
	}

	private function checkPrice(string $itemName): void
	{
		$itemPrice = self::$itemPrices[$itemName];
		$totalInsertedCoinsValue = $this->coinArrayAdder->__invoke($this->insertedCoins);
		if ($itemPrice > $totalInsertedCoinsValue) {
			throw new NotEnoughInsertedCoinsException($itemPrice - $totalInsertedCoinsValue);
		}
	}

	private function checkAvailableChange(string $itemName): void
	{
		$itemPrice = self::$itemPrices[$itemName];
		$totalInsertedCoinsValue = $this->coinArrayAdder->__invoke($this->insertedCoins);
		$neededChangeAmount = $totalInsertedCoinsValue - $itemPrice;
		$neededCoins = $this->splitAmountIntoCoins($neededChangeAmount);
		if (!empty($neededCoins)) {
			throw new NotEnoughChangeException($itemPrice);
		}
	}

	private function splitAmountIntoCoins(float $amount): array
	{
		$coins = [];
		$amount = intval($amount*100);
		while($amount > 0) {
			if ($amount > intval(Coin::TWENTYFIVE_CENTS * 100)) {
				$this->extractNumberOfCoinsFromAmount($coins, $amount, Coin::TWENTYFIVE_CENTS);
			} else if ($amount > intval(Coin::TEN_CENTS * 100)) {
				$this->extractNumberOfCoinsFromAmount($coins, $amount, Coin::TEN_CENTS);
			} else if ($amount > intval(Coin::FIVE_CENTS * 100)) {
				$this->extractNumberOfCoinsFromAmount($coins, $amount, Coin::FIVE_CENTS);
			}
		}
		return $coins;
	}

	private function extractNumberOfCoinsFromAmount(array &$coins, int &$amount, $coinValue): void
	{
		$numberOfCoins = floor($amount / intval($coinValue * 100));
		$amount = $amount % intval($coinValue * 100);
		$coins[$coinValue] = $numberOfCoins;
	}

	private function reduceStock(string $itemName): void
	{
		$this->stock[$itemName]--;
	}

	private function payItem(string $itemName): void
	{

	}
}