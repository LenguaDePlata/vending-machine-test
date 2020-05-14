<?php

namespace App\Domain\VendingMachine\Exceptions;

class NotEnoughStockException extends \Exception
{
	public function __construct()
	{
		parent::__construct('There is not enough stock for the selected item');
	}
}