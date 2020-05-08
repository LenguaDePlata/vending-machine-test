<?php

namespace Application\Commands;

class ServiceCommand extends BaseCommand implements Command
{
	public function run(): string
	{
		return 'SERVICE';
	}
}