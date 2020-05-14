<?php

namespace App\Domain\VendingMachine\Exceptions;

class NotEnoughChangeException extends \Exception
{
	public function __construct()
	{
		parent::__construct('The vending machine does not have enough available coins to return your change for purchasing this item. Please, return all your inserted coins and try again inserting the exact amount for that item ('.$itemPrice.')');
	}
}