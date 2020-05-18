<?php

namespace Tests\Functional\UI\Console\Reader;

use PHPUnit\Framework\TestCase;
use App\UI\Console\Reader;
use App\Domain\VendingMachine\Models\VendingMachine;
use DI\Container;

abstract class ReaderTestCase extends TestCase
{
	protected $testInputStream;
	protected $reader;

	protected function setUp(): void
	{
		$container = new Container();
		$this->reader = $container->get(Reader::class);
		$this->testInputStream = fopen('php://memory', 'w+');

		$this->givenAnEmptyStartingVendingMachine();
		$this->givenNoChangeIsInsertedInTheVendingMachine();
	}

	protected function givenAnEmptyStartingVendingMachine(): void
	{
		fputs($this->testInputStream, '0, 0, 0, 0, 0, 0, SERVICE');
		rewind($this->testInputStream);
		$this->reader->readLine($this->testInputStream);
		$this->reader->executeCommand();
		ftruncate($this->testInputStream, 0);
	}

	protected function givenNoChangeIsInsertedInTheVendingMachine(): void
	{
		fputs($this->testInputStream, 'RETURN-COIN');
		rewind($this->testInputStream);
		$this->reader->readLine($this->testInputStream);
		$this->reader->executeCommand();
		ftruncate($this->testInputStream, 0);
	}

	protected function tearDown(): void
	{
		fclose($this->testInputStream);
		unset($this->reader);
	}

	protected function whenTheCommandIsRead(): void
	{
		$this->reader->readLine($this->testInputStream);
	}
}