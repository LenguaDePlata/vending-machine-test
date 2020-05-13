<?php

namespace App\Application\Validators;

interface Validator
{
	public function validate(array $arguments): void;
}