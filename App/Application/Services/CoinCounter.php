<?php

namespace App\Application\Services;

use App\Domain\VendingMachine\ValueObjects\Change;

class CoinCounter
{
	public function __invoke(): Change
	{
		return new Change(0, 0, 0);
	}
}