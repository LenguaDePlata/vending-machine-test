<?php

namespace App\Application\Commands;

abstract class BaseCommand
{
	protected $commandLine;
	protected $arguments = [];
	protected $validationErrors = [];

	public function setCommandLine(string $commandLine): void
	{
		$this->commandLine = $commandLine;
		$this->parseCommandLine();
	}

	protected function parseCommandLine(): void
	{
		$this->arguments = explode(', ', $this->commandLine);
		array_pop($this->arguments);
	}
}