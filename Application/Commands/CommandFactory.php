<?php

namespace Application\Commands;

use Application\Exceptions\InvalidCommandException;

class CommandFactory
{
	private static $existingCommands = ['get', 'service', 'returnCoin', 'insertCoin'];

	public static function build(string $commandLine): Command
	{
		$commandName = self::parseCommandName($commandLine);
		if (!in_array($commandName, self::$existingCommands)) {
			throw new InvalidCommandException($commandName);
		}

		$commandObjectName = '\Application\Commands\\'.ucfirst($commandName).'Command';
		$command = new $commandObjectName($commandLine);

		return $command;
	}

	private static function parseCommandName(string $commandLine): string
	{
		$commandBits = explode(', ', $commandLine);
		$commandName = array_pop($commandBits);
		if (is_numeric($commandName)) {
			$commandName = 'insertCoin';
		} else {
			if (self::isGetterCommand($commandName)) {
				$commandName = 'get';
			}
		}
		return $commandName;
	}

	private static function isGetterCommand(string $commandName): bool
	{
		$commandBits = explode('-', $commandName);
		return (strtolower($commandBits[0]) == 'get');
	}
}