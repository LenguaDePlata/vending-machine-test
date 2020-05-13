<?php

namespace App\Application\Commands;

class InsertCoinCommand extends BaseCommand implements Command
{
	private $coinInserter;

	public function __construct(CoinInserter $coinInserter)
	{
		$this->coinInserter = $coinInserter;
	}

	public function run(): string
	{
		return 'INSERTED';
	}

	protected function validateArguments(): void
	{
		
	}
}