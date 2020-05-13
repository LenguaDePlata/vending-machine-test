<?php

namespace App\Application\Commands;

use App\Application\UseCases\CoinInserter;
use App\Application\Validators\InsertCoinValidator;

class InsertCoinCommand extends BaseCommand implements Command
{
	private $coinInserter;
	private $coinCounter;

	public function __construct(
		CoinInserter $coinInserter,
		CoinCounter $coinCounter,
		InsertCoinValidator $insertCoinValidator)
	{
		$this->coinInserter = $coinInserter;
		$this->coinCounter = $coinCounter;
		parent::__construct($insertCoinValidator);
	}

	public function run(): string
	{
		$insertedChange = $this->coinCounter->__invoke($this->arguments);
		$this->coinInserter->__invoke($insertedChange);
		return '';
	}

	protected function parseCommandLine(): void
	{
		$this->arguments = explode(', ', $this->commandLine);
	}
}