<?php

namespace Tests\Functional\UI\Console\Reader;

class ReaderInsertCoinTest extends ReaderTestCase
{
	public function testReaderExecutesInsertCoinCommand(): void
	{
		$this->givenACorrectInsertCoinCommand();
		$this->whenTheCommandIsExecuted();
		$this->thenTheOnlyCoinsInsideTheVendingMachineAreThoseInserted();
	}

	private function givenACorrectInsertCoinCommand(): void
	{
		fputs($this->testInputStream, '0.10, 1, 0.25');
		rewind($this->testInputStream);
	}

	private function whenTheCommandIsExecuted(): void
	{
		$this->reader->readLine($this->testInputStream);
		$this->assertEquals($this->reader->executeCommand(), '');
	}

	private function thenTheOnlyCoinsInsideTheVendingMachineAreThoseInserted(): void
	{
		ftruncate($this->testInputStream, 0);
		fputs($this->testInputStream, 'RETURN-COIN');
		rewind($this->testInputStream);
		$this->reader->readLine($this->testInputStream);
		$this->assertEquals($this->reader->executeCommand(), '-> 0.10, 0.25, 1');
	}
}