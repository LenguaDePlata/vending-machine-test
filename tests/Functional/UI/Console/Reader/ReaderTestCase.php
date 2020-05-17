<?php

namespace Tests\Functional\UI\Console\Reader;

use PHPUnit\Framework\TestCase;
use App\UI\Console\Reader;
use DI\Container;

abstract class ReaderTestCase extends TestCase
{
	protected $testInputStream;
	protected $reader;

	public function setUp(): void
	{
		$container = new Container();
		$this->reader = $container->get(Reader::class);
		$this->testInputStream = fopen('php://memory', 'w+');
	}

	public function tearDown(): void
	{
		fclose($this->testInputStream);
	}

	protected function whenTheCommandIsRead(): void
	{
		$this->reader->readLine($this->testInputStream);
	}
}