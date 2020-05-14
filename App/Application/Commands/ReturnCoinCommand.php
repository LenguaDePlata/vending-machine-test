<?php

namespace App\Application\Commands;

use App\Application\Services\CoinCounter;
use App\Application\Services\ChangeToCoinsParser;
use App\Application\UseCases\CoinReturner;
use App\Application\Validators\ReturnCoinValidator;
use App\Domain\VendingMachine\ValueObjects\Change;

class ReturnCoinCommand extends BaseCommand implements Command
{
	private $coinReturner;
	private $coinCounter;
	private $changeToCoinsParser;

	public function __construct(
		CoinReturner $coinReturner,
		CoinCounter $coinCounter,
		ChangeToCoinsParser $changeToCoinsParser,
		ReturnCoinValidator $returnCoinValidator)
	{
		$this->coinReturner = $coinReturner;
		$this->coinCounter = $coinCounter;
		$this->changeToCoinsParser = $changeToCoinsParser;
		parent::__construct($returnCoinValidator);
	}

	public function run(): string
	{
		$insertedChange = $this->coinCounter->__invoke($this->arguments);
		$returnedChange = $this->coinReturner->__invoke($insertedChange);
		return $this->parseResponse($returnedChange);
	}

	private function parseResponse(Change $returnedChange): string
	{
		return '-> '. $this->changeToCoinsParser->__invoke($returnedChange);
	}
}