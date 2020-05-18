<?php

namespace Tests\Functional\UI\Console\Reader;

class ReaderGetTest extends ReaderTestCase
{
	public function testReaderExecutesGetCommand(): void
	{
		$this->givenAVendingMachineWithEnoughStockAndChange();
		$this->givenACorrectGetCommand();
		$this->whenTheCommandIsRead();
		$this->thenTheCommandReturnsTheItemPurchasedAndTheChange();
	}

	private function givenAVendingMachineWithEnoughStockAndChange(): void
	{
		fputs($this->testInputStream, '1, 1, 1, 1, 1, 1, SERVICE');
		rewind($this->testInputStream);
		$this->reader->readLine($this->testInputStream);
		$this->reader->executeCommand();
		ftruncate($this->testInputStream, 0);
	}

	private function givenACorrectGetCommand(): void
	{
		fputs($this->testInputStream, '0.10, 1, 0.25, GET-SODA');
		rewind($this->testInputStream);
	}

	private function thenTheCommandReturnsTheItemPurchasedAndTheChange(): void
	{
		$this->assertEquals($this->reader->executeCommand(), '-> SODA, 0.10, 0.25');
	}

	protected function tearDown(): void
	{
		fputs($this->testInputStream, '0, 0, 0, 0, 0, 0, SERVICE');
		rewind($this->testInputStream);
		$this->reader->readLine($this->testInputStream);
		$this->reader->executeCommand();
		ftruncate($this->testInputStream, 0);

		fputs($this->testInputStream, 'RETURN-COIN');
		rewind($this->testInputStream);
		$this->reader->readLine($this->testInputStream);
		$this->reader->executeCommand();
		ftruncate($this->testInputStream, 0);

		parent::tearDown();
	}
}