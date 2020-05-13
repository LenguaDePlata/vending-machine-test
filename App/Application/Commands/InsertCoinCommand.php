<?php

namespace App\Application\Commands;

use App\Application\UseCases\CoinInserter;
use App\Application\Validators\InsertCoinValidator;

class InsertCoinCommand extends BaseCommand implements Command
{
	private $coinInserter;

	public function __construct(
		CoinInserter $coinInserter,
		InsertCoinValidator $insertCoinValidator)
	{
		$this->coinInserter = $coinInserter;
		parent::__construct($insertCoinValidator);
	}

	public function run(): string
	{
		return 'INSERTED';
	}

	protected function parseCommandLine(): void
	{
		$this->arguments = explode(', ', $this->commandLine);
	}
}