<?php

namespace Application\Commands;

class GetCommand extends BaseCommand implements Command
{
	public function run(): string
	{
		return 'SODA';
	}
}