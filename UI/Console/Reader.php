<?php

namespace UI\Console;

use Application\Commands\CommandFactory;

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
		try {
			$command = CommandFactory::build($this->currentLine);
			$response = $command->run();
		} catch (\Exception $e) {
			$response = $e->getMessage();
		}
		return $response;
	}
}