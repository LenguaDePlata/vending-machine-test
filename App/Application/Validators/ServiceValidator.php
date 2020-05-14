<?php

namespace App\Application\Validators;

use App\Application\Exceptions\NotEnoughArgumentsException;
use App\Application\Exceptions\InvalidArgumentTypeException;

class ServiceValidator implements Validator
{
	private const NUMBER_OF_ARGUMENTS = 6;

	public function validate(array $arguments): void
	{
		if (count($arguments) != self::NUMBER_OF_ARGUMENTS) {
			throw new InvalidNumberOfArgumentsException(self::NUMBER_OF_ARGUMENTS);
		}
		foreach ($arguments as $argument) {
			if (!preg_match('/^\d+$/', $argument)) {
				throw new InvalidArgumentTypeException('int');
			}
		}
	}
}