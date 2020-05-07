<?php

namespace App\UI\Console;

use App\Application\Console\Commands\CommandFactory;

class Reader
{	
	private $currentLine;

	public function readLine()
	{
		return ($this->currentLine = trim(fgets(STDIN)));
	}

	public function quitted()
	{
		return ($this->currentLine === 'quit') || ($this->currentLine === 'q');
	}

	public function executeCommand()
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

	private function isValidCommand($command)
	{
		return !is_null($command);
	}

	private function getInvalidResponse()
	{
		return 'Unknown or invalid command';
	}
}