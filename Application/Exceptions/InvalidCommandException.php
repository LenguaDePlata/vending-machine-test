<?php

namespace Application\Exceptions;

class InvalidCommandException extends \Exception
{
	public function __construct(string $invalidCommand)
	{
		parent::__construct("$invalidCommand is an unknown or invalid command");
	}
}