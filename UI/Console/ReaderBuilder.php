<?php

namespace UI\Console;

use Application\Commands\CommandFactory;
use Application\Services\CamelCaser;

class ReaderBuilder
{
	public static function build(): Reader
	{
		$camelCaserService = new CamelCaser();
		$commandFactory = new CommandFactory($camelCaserService);
		return new Reader($commandFactory);
	}
}