<?php

namespace App\Application\Commands;

use App\Application\Services\CoinCounter;
use App\Application\Services\ChangeToCoinsParser;
use App\Application\UseCases\CoinReturner;
use App\Application\UseCases\CoinInserter;
use App\Application\Validators\ReturnCoinValidator;
use App\Domain\VendingMachine\ValueObjects\Change;

class ReturnCoinCommand extends BaseCommand implements Command
{
	private $coinReturner;
	private $coinInserter;
	private $coinCounter;
	private $changeToCoinsParser;

	public function __construct(
		CoinReturner $coinReturner,
		CoinInserter $coinInserter,
		CoinCounter $coinCounter,
		ChangeToCoinsParser $changeToCoinsParser,
		ReturnCoinValidator $returnCoinValidator)
	{
		$this->coinReturner = $coinReturner;
		$this->coinInserter = $coinInserter;
		$this->coinCounter = $coinCounter;
		$this->changeToCoinsParser = $changeToCoinsParser;
		parent::__construct($returnCoinValidator);
	}

	public function run(): string
	{
		$insertedChange = $this->coinCounter->__invoke($this->arguments);
		$this->coinInserter->__invoke($insertedChange);
		$returnedChange = $this->coinReturner->__invoke();
		return $this->parseResponse($returnedChange);
	}

	private function parseResponse(Change $returnedChange): string
	{
		return '-> '. $this->changeToCoinsParser->__invoke($returnedChange);
	}
}