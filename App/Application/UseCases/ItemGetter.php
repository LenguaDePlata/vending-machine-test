<?php

namespace App\Application\UseCases;

use App\Domain\VendingMachine\ValueObjects\Change;

class ItemGetter
{
	public function __invoke(string $itemName): Change
	{
		return new Change(0,0,0);
	}
}