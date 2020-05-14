<?php

namespace App\Domain\VendingMachine\Exceptions;

class NotEnoughInsertedCoinsException extends \Exception
{
	public function __construct(float $changeNeeded)
	{
		parent::__construct('The change inserted is not enough for purchasing this item. Please, insert '.$changeNeeded.' and try again or return your coins');
	}
}