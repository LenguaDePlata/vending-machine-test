<?php

namespace App\Application\UseCases;

use App\Domain\VendingMachine\ValueObjects\Change;

class CoinReturner
{
	public function __invoke(Change $insertedChange): Change
	{
		return new Change(0,0,0);
	}
}