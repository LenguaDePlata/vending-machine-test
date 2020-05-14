<?php

namespace App\Application\Commands;

use App\Application\UseCases\ServiceConfigurer;
use App\Application\Validators\ServiceValidator;
use App\Domain\VendingMachine\ValueObjects\Change;
use App\Domain\VendingMachine\ValueObjects\Stock;

class ServiceCommand extends BaseCommand implements Command
{
	private const FIVE_CENTS_COINS_ARG_POSITION = 0;
	private const TEN_CENTS_COINS_ARG_POSITION = 1;
	private const TWENTYFIVE_CENTS_COINS_ARG_POSITION = 2;

	private const SODA_ITEMS_ARG_POSITION = 3;
	private const WATER_ITEMS_ARG_POSITION = 4;
	private const JUICE_ITEMS_ARG_POSITION = 5;

	private $serviceConfigurer;
	
	public function __construct(
		ServiceConfigurer $serviceConfigurer,
		ServiceValidator $serviceValidator)
	{
		$this->serviceConfigurer = $serviceConfigurer;
		parent::__construct($serviceValidator);
	}

	public function run(): string
	{
		$availableChange = $this->getAvailableChange();
		$availableItems = $this->getAvailableItems();
		$this->serviceConfigurer->__invoke($availableChange, $availableItems);
		return self::EMPTY_RESPONSE;
	}

	private function getAvailableChange(): Change
	{
		$fiveCentsCoins = $this->arguments[self::FIVE_CENTS_COINS_ARG_POSITION];
		$tenCentsCoins = $this->arguments[self::TEN_CENTS_COINS_ARG_POSITION];
		$twentyfiveCentsCoins = $this->arguments[self::TWENTYFIVE_CENTS_COINS_ARG_POSITION];
		return new Change($fiveCentsCoins, $tenCentsCoins, $twentyfiveCentsCoins);
	}

	private function getAvailableItems(): Stock
	{
		$sodaItems = $this->arguments[self::SODA_ITEMS_ARG_POSITION];
		$waterItems = $this->arguments[self::WATER_ITEMS_ARG_POSITION];
		$juiceItems = $this->arguments[self::JUICE_ITEMS_ARG_POSITION];
		return new Stock($sodaItems, $waterItems, $juiceItems);
	}
}