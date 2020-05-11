<?php

namespace App\Application\Exceptions;

class NotEnoughArgumentsException extends \Exception
{
	public function __construct()
	{
		parent::__construct('Too few arguments provided for this command');
	}
}