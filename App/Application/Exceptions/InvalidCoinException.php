<?php

namespace App\Application\Exceptions;

class InvalidCoinException extends \Exception
{
	public function __construct(string $invalidCoin, array $validCoins)
	{
		$validCoinsString = implode(', ', $validCoins);
		parent::__construct($invalidCoin.' is not an accepted coin by the vending machine. Please introduce only coins with the following values: '.$validCoinsString);
	}
}