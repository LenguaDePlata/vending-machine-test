<?php

namespace Tests\Functional\UI\Console\Reader;

class ReaderServiceTest extends ReaderTestCase
{
	public function testReaderExecutesServiceCommand(): void
	{
		fputs($this->testInputStream, '1, 1, 1, 1, 1, 1, SERVICE');
		rewind($this->testInputStream);
		$this->reader->readLine($this->testInputStream);
		$this->assertEquals($this->reader->executeCommand(), '');
	}
}