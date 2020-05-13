<?php

namespace App\Application\Commands;

class ReturnCoinCommand extends BaseCommand implements Command
{
	public function run(): string
	{
		return 'COIN';
	}
}