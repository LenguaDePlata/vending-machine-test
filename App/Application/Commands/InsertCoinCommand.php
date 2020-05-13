<?php

namespace App\Application\Commands;

use App\Application\UseCases\CoinInserter;

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
}