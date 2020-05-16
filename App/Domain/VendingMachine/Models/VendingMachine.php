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

	public function ejectInsertedCoins(): array
	{
		$ejectedCoins = $this->insertedCoins;
		$this->insertedCoins = [];
		return $ejectedCoins;
	}

	public function getItem(string $itemName): array
	{
		$this->initializePurchaseChange();
		$this->checkStock($itemName);
		$this->checkPrice($itemName);
		$this->checkAvailableChange($itemName);

		$this->reduceStock($itemName);
		$this->payItem($itemName);

		return $this->ejectPurchaseChange();
	}

	private function initializePurchaseChange(): void
	{
		$this->changeToReturn = [
			Coin::FIVE_CENTS => 0,
			Coin::TEN_CENTS => 0,
			Coin::TWENTYFIVE_CENTS => 0,
			Coin::ONE_EURO => 0
		];
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
		$combinedVendingMachineChangeAfterPaying = $this->combineCoinArrays($this->change, $this->insertedCoins);

		if (!$this->isGivenAmountContainedInThisAvailableChange($neededChangeAmount, $combinedVendingMachineChangeAfterPaying)) {
			throw new NotEnoughChangeException($itemPrice);
		}
	}

	private function combineCoinArrays(array $first, array $second): array
	{
		$result = [];
		$missingKeys = array_diff_key($second, $first);
		foreach ($first as $key => $value) {
			if (isset($second[$key])) {
				$result[$key] = $first[$key] + $second[$key];
			} else {
				$result[$key] = $first[$key];
			}
		}
		foreach ($missingKeys as $key) {
			$result[$key] = $second[$key];
		}
		return $result;
	}

	private function isGivenAmountContainedInThisAvailableChange(float $givenAmount, array $availableChange): bool
	{
		$areContained = false;
		if ($givenAmount == 0) {
			$areContained = true;
		} else if ($givenAmount > 0) {
			if ($givenAmount >= Coin::TWENTYFIVE_CENTS && $availableChange[Coin::TWENTYFIVE_CENTS] > 0) {
				$availableChange[Coin::TWENTYFIVE_CENTS]--;
				$newGivenAmount = $givenAmount - Coin::TWENTYFIVE_CENTS;
				$areContained = $this->isGivenAmountContainedInThisAvailableChange($newGivenAmount, $availableChange);
				if ($areContained) {
					$this->changeToReturn[Coin::TWENTYFIVE_CENTS]++;
					return true;
				}
				$availableChange[Coin::TWENTYFIVE_CENTS]++;
			}

			if ($givenAmount >= Coin::TEN_CENTS && $availableChange[Coin::TEN_CENTS] > 0) {
				$availableChange[Coin::TEN_CENTS]--;
				$newGivenAmount = $givenAmount - Coin::TEN_CENTS;
				$areContained = $this->isGivenAmountContainedInThisAvailableChange($newGivenAmount, $availableChange);
				if ($areContained) {
					$this->changeToReturn[Coin::TEN_CENTS]++;
					return true;
				}
				$availableChange[Coin::TEN_CENTS]++;
			}

			if ($givenAmount >= Coin::FIVE_CENTS && $availableChange[Coin::FIVE_CENTS] > 0) {
				$availableChange[Coin::FIVE_CENTS]--;
				$newGivenAmount = $givenAmount - Coin::FIVE_CENTS;
				$areContained = $this->isGivenAmountContainedInThisAvailableChange($newGivenAmount, $availableChange);
				if ($areContained) {
					$this->changeToReturn[Coin::FIVE_CENTS]++;
					return true;
				}
				$availableChange[Coin::FIVE_CENTS]++;
			}
		}
		return $areContained;
	}

	private function reduceStock(string $itemName): void
	{
		$this->stock[$itemName]--;
	}

	private function payItem(string $itemName): void
	{
		$this->change = $this->combineCoinArrays($this->change, $this->insertedCoins);
		$this->change = $this->substractCoinArrays($this->change, $this->changeToReturn);
		$this->insertedCoins = [];
	}

	private function substractCoinArrays(array $first, array $second): array
	{
		$result = [];
		foreach ($first as $key => $value) {
			if (isset($second[$key])) {
				$result[$key] = $first[$key] - $second[$key];
			} else {
				$result[$key] = $first[$key];
			}
		}
		return $result;
	}

	private function ejectPurchaseChange(): array
	{
		$ejectedChange = $this->changeToReturn;
		$this->changeToReturn = [];
		
		return $ejectedChange;
	}
}