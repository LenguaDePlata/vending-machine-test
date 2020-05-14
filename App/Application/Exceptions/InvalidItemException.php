<?php

namespace App\Application\Exceptions;

class InvalidItemException extends \Exception
{
	public function __construct(string $invalidItem, array $validItems)
	{
		$validItemsString = implode(', ', $validItems);
		parent::__construct($invalidItem.' is not an item provided by the vending machine. Please ask only for the following items: '.$validItemsString);
	}
}