<?php

namespace Application\Commands;

class InsertCoinCommand extends BaseCommand implements Command
{
	public function run(): string
	{
		return 'INSERTED';
	}
}