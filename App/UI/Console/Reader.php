<?php

namespace App\UI\Console;

use App\Application\Commands\CommandFactory;
use App\Application\Commands\CommandEnum;

class Reader
{
	private $currentLine;
	private $commandFactory;

	public function __construct(CommandFactory $commandFactory)
	{
		$this->commandFactory = $commandFactory;
	}

	public function readLine($stream = STDIN): string
	{
		return ($this->currentLine = trim(fgets($stream)));
	}

	public function quitted(): bool
	{
		return ($this->currentLine === strtoupper(CommandEnum::QUIT));
	}

	public function executeCommand(): string
	{
		$response = '';
		try {
			$command = $this->commandFactory->create($this->currentLine);
			$response = $command->run();
		} catch (\Exception $e) {
			$response = $e->getMessage();
		}
		return $response;
	}
}