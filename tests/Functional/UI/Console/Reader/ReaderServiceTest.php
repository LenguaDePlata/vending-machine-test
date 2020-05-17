<?php

namespace Tests\Functional\UI\Console\Reader;

class ReaderServiceTest extends ReaderTestCase
{
	public function testReaderExecutesServiceCommand(): void
	{
		$this->givenACorrectServiceCommand();
		$this->whenTheCommandIsRead();
		$this->thenTheCommandReturnsAnEmptyResponse();
	}

	private function givenACorrectServiceCommand(): void
	{
		fputs($this->testInputStream, '1, 1, 1, 1, 1, 1, SERVICE');
		rewind($this->testInputStream);
	}

	private function thenTheCommandReturnsAnEmptyResponse(): void
	{
		$this->assertEquals($this->reader->executeCommand(), '');
	}
}