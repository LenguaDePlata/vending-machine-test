<?php

namespace App\Application\Commands;

use App\Application\Validators\Validator;

abstract class BaseCommand
{
	protected const EMPTY_RESPONSE = '';
	
	protected $commandLine;
	protected $arguments = [];
	protected $validator;

	public function __construct(Validator $validator)
	{
		$this->validator = $validator;
	}

	public function setCommandLine(string $commandLine): void
	{
		$this->commandLine = $commandLine;
		$this->parseCommandLine();
		$this->validator->validate($this->arguments);
	}

	protected function parseCommandLine(): void
	{
		$this->arguments = explode(', ', $this->commandLine);
		array_pop($this->arguments);
	}
}