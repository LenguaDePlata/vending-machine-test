<?php

namespace App\Application\UseCases;

use App\Domain\VendingMachine\ValueObjects\Change;
use App\Domain\VendingMachine\ValueObjects\Stock;
use App\Domain\VendingMachine\Builders\VendingMachineBuilder;

class ServiceConfigurer
{
	private $vendingMachineBuilder;

	public function __construct(VendingMachineBuilder $vendingMachineBuilder)
	{
		$this->vendingMachineBuilder = $vendingMachineBuilder;
	}

	public function __invoke(Change $availableChange, Stock $availableItems): void
	{
		$this->vendingMachineBuilder->build($availableChange, $availableItems);
	}
}