<?php

namespace App\Console\Commands;

abstract class BaseCommand
{
	protected $commandLine;
	protected $arguments = [];
	protected $validationErrors = [];

	public function __construct($commandLine)
	{
		$this->commandLine = $commandLine;
		$this->parseCommandLine();
	}

	private function parseCommandLine(): void
	{
		
	}
}