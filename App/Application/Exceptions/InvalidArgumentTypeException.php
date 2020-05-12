<?php

namespace App\Application\Exceptions;

class InvalidArgumentTypeException extends \Exception
{
	public function __construct(string $validType)
	{
		parent::__construct('Invalid type for the argument passed. It should be of type '.$validType);
	}
}