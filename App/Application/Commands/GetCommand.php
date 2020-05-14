<?php

namespace App\Application\Commands;

use App\Application\Services\CoinCounter;
use App\Application\Services\ChangeToCoinsParser;
use App\Application\UseCases\ItemGetter;
use App\Application\UseCases\CoinInserter;
use App\Application\Validators\GetValidator;
use App\Domain\VendingMachine\ValueObjects\Change;

class GetCommand extends BaseCommand implements Command
{
	private $itemGetter;
	private $coinInserter;
	private $coinCounter;
	private $changeToCoinsParser;

	private $itemName;
	private $insertedCoins;

	public function __construct(
		ItemGetter $itemGetter,
		CoinInserter $coinInserter,
		CoinCounter $coinCounter,
		ChangeToCoinsParser $changeToCoinsParser,
		GetValidator $getValidator)
	{
		$this->itemGetter = $itemGetter;
		$this->coinInserter = $coinInserter;
		$this->coinCounter = $coinCounter;
		$this->changeToCoinsParser = $changeToCoinsParser;
		parent::__construct($getValidator);
	}

	public function run(): string
	{
		$insertedChange = $this->coinCounter->__invoke($this->insertedCoins);
		$this->coinInserter->__invoke($insertedChange);
		$returnedChange = $this->itemGetter->__invoke($this->itemName);
		return $this->parseResponse($returnedChange);
	}

	private function parseResponse(Change $returnedChange): string
	{
		$response = '-> '.$this->itemName;
		$coinString = $this->changeToCoinsParser->__invoke($returnedChange);
		if (!empty($coinString)) {
			$response .= ', ' . $coinString;
		}
		return $response;
	}

	protected function parseCommandLine(): void
	{
		$this->arguments = explode(', ', $this->commandLine);
		
		$commandName = array_pop($this->arguments);
		$commandNameArray = explode('-', $commandName);
		
		$this->itemName = array_pop($commandNameArray);
		$this->insertedCoins = $this->arguments;
		
		$this->arguments[] = $commandName;
	}
}