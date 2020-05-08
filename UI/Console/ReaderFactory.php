<?php

namespace UI\Console;

use Application\Commands\CommandFactory;
use Application\Services\CamelCaser;

class ReaderFactory
{
	public static function create(): Reader
	{
		$camelCaserService = new CamelCaser();
		$commandFactory = new CommandFactory($camelCaserService);
		return new Reader($commandFactory);
	}
}