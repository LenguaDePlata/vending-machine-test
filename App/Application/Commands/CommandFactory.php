<?php

namespace App\Application\Commands;

use App\Application\Exceptions\InvalidCommandException;
use App\Application\Services\CamelCaser;
use DI\Container;

class CommandFactory
{
	private static $existingCommands = [CommandEnum::GET, CommandEnum::SERVICE, CommandEnum::RETURN_COIN, CommandEnum::INSERT_COIN];

	private $camelCaser;
	private $container;

	public function __construct(CamelCaser $camelCaser, Container $container)
	{
		$this->camelCaser = $camelCaser;
		$this->container = $container;
	}

	public function create(string $commandLine): Command
	{
		$commandName = $this->parseCommandName($commandLine);
		if (!in_array($commandName, self::$existingCommands)) {
			throw new InvalidCommandException($commandName);
		}

		$commandObjectName = '\App\Application\Commands\\'.$commandName.'Command';
		$command = $this->container->get($commandObjectName);
		$command->setCommandLine($commandLine);

		return $command;
	}

	private function parseCommandName(string $commandLine): string
	{
		$commandBits = explode(', ', $commandLine);
		$commandName = array_pop($commandBits);
		if (is_numeric($commandName)) {
			$commandName = CommandEnum::INSERT_COIN;
		} else {
			if ($this->isGetterCommand($commandName)) {
				$commandName = CommandEnum::GET;
			} else {
				$commandName = $this->camelCaser->__invoke($commandName);
			}
		}
		return $commandName;
	}

	private function isGetterCommand(string $commandName): bool
	{
		$commandBits = explode('-', $commandName);
		return (ucfirst(strtolower($commandBits[0])) == CommandEnum::GET);
	}
}