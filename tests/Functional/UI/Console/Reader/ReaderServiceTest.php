<?php

namespace Tests\Functional\UI\Console\Reader;

use PHPUnit\Framework\TestCase;
use App\UI\Console\Reader;
use DI\Container;

class ReaderServiceTest extends TestCase
{
	public function testReaderExecutesServiceCommand(): void
	{
		$container = new Container();
		$reader = $container->get(Reader::class);

		$testInputStream = fopen('php://temp', 'w+');
		fputs($testInputStream, '1, 1, 1, 1, 1, 1, SERVICE');
		rewind($testInputStream);
		$reader->readLine($testInputStream);
		$this->assertEquals($reader->executeCommand(), '');
		fclose($testInputStream);
	}
}