<?php

namespace Tests\Functional\UI\Console\Reader;

class ReaderReturnCoinTest extends ReaderTestCase
{
	public function testReaderExecutesReturnCoinCommand(): void
	{
		$this->givenACorrectReturnCoinCommand();
		$this->whenTheCommandIsRead();
		$this->thenTheCommandReturnsTheInsertedCoinsInTheArguments();
	}

	private function givenACorrectReturnCoinCommand(): void
	{
		fputs($this->testInputStream, '0.10, 1, 0.25, RETURN-COIN');
		rewind($this->testInputStream);
	}

	private function thenTheCommandReturnsTheInsertedCoinsInTheArguments(): void
	{
		$this->assertEquals($this->reader->executeCommand(), '-> 0.10, 0.25, 1');
	}
}