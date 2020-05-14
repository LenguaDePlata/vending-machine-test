<?php

namespace App\Application\Services;

use App\Domain\VendingMachine\ValueObjects\Change;

class ChangeToCoinsParser
{
	public function __invoke(Change $change): string
	{
		return '';
	}
}