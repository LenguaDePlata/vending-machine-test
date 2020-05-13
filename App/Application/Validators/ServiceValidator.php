<?php

namespace App\Application\Validators;

use App\Application\Exceptions\NotEnoughArgumentsException;
use App\Application\Exceptions\InvalidArgumentTypeException;

class ServiceValidator implements Validator
{
	public function validate(array $arguments): void
	{
		if (count($arguments) < 6) {
			throw new NotEnoughArgumentsException();
		}
		foreach ($arguments as $argument) {
			if (!preg_match('/^\d+$/', $argument)) {
				throw new InvalidArgumentTypeException('int');
			}
		}
	}
}