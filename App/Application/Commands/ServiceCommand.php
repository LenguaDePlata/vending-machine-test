<?php

namespace App\Application\Commands;

use App\Application\UseCases\ServiceConfigurer;
use App\Domain\VendingMachine\ValueObjects\Change;
use App\Domain\VendingMachine\ValueObjects\Stock;

class ServiceCommand extends BaseCommand implements Command
{
	private $serviceConfigurer;
	
	public function __construct(ServiceConfigurer $serviceConfigurer)
	{
		$this->serviceConfigurer = $serviceConfigurer;
	}

	public function run(): string
	{
		$availableChange = $this->getAvailableChange();
		$availableItems = $this->getAvailableItems();
		$this->serviceConfigurer->__invoke($availableChange, $availableItems);
		return 'Vending machine change and stock set';
	}

	private function getAvailableChange(): Change
	{

	}

	private function getAvailableItems(): Stock
	{

	}
}