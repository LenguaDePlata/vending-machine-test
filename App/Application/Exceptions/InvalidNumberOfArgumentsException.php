<?php

namespace App\Application\Exceptions;

class InvalidNumberOfArgumentsException extends \Exception
{
	public function __construct(int $validNumberOfArguments)
	{
		parent::__construct('Invalid number of arguments provided for this command. The right number of commands should be '.$validNumberOfArguments);
	}
}