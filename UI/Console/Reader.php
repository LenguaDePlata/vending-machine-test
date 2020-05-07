<?php

namespace App\UI\Console;

use App\Application\Commands\CommandFactory;

class Reader
{	
	private const QUIT = 'quit';
	private $currentLine;

	public function readLine(): string
	{
		return ($this->currentLine = trim(fgets(STDIN)));
	}

	public function quitted(): bool
	{
		return ($this->currentLine === self::QUIT);
	}

	public function executeCommand(): string
	{
		$response = '';
		$command = CommandFactory::build($this->currentLine);
		if ($this->isValidCommand($command)) {
			$response = $command->run();
		} else {
			$response = $this->getInvalidResponse();
		}
		return $response;
	}

	private function isValidCommand($command): bool
	{
		return !is_null($command);
	}

	private function getInvalidResponse(): string
	{
		return 'Unknown or invalid command';
	}
}