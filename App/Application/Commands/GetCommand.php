<?php

namespace App\Application\Commands;

class GetCommand extends BaseCommand implements Command
{
	public function run(): string
	{
		return 'SODA';
	}

	protected function validateArguments(): void
	{
		
	}
}