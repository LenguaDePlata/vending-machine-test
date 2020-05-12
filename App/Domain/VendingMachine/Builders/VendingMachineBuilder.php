<?php

namespace App\Domain\VendingMachine\Builders;

use App\Domain\VendingMachine\ValueObjects\Change;
use App\Domain\VendingMachine\ValueObjects\Stock;
use App\Domain\VendingMachine\Models\VendingMachine;

class VendingMachineBuilder
{
	public function build(Change $availableChange, Stock $availableItems): VendingMachine
	{
		$vendingMachine = VendingMachine::getInstance();
		$vendingMachine->setStock(
			$availableItems->getWaterItems(),
			$availableItems->getSodaItems(),
			$availableItems->getJuiceItems(),
		);
		$vendingMachine->setChange(
			$availableChange->getFiveCentCoins(),
			$availableChange->getTenCentCoins(),
			$availableChange->getTwentyFiveCentCoins()
		);
		return $vendingMachine;
	}
}