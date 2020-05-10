<?php

namespace App\Application\UseCases;

use App\Domain\VendingMachine\ValueObjects\Change;
use App\Domain\VendingMachine\ValueObjects\Stock;

class ServiceConfigurer
{
	public function __invoke(Change $availableChange, Stock $availableItems): void
	{
		// $this->vendingMachineBuilder->build($availableChange, $availableItems);
	}
}