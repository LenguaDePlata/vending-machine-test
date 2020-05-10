<?php

namespace App\Application\Commands;

use App\Application\UseCases\ServiceConfigurer;

class ServiceCommand extends BaseCommand implements Command
{
	public function run(): string
	{
		$availableChange = $this->getAvailableChange();
		$availableItems = $this->getAvailableItems();
		$this->serviceConfigurer->__invoke($availableChange, $availableItems);
		return 'Vending machine change and stock set';
	}
}