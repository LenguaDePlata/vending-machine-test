<?php

namespace App\Domain\VendingMachine\ValueObjects;

class Stock
{
	private $waterItems;
	private $sodaItems;
	private $juiceItems;

	public function __construct(int $waterItems,
								int $sodaItems,
								int $juiceItems)
	{
		$this->waterItems = $this->waterItems;
		$this->sodaItems = $this->sodaItems;
		$this->juiceItems = $this->juiceItems;
	}

	public function getWaterItems(): int
	{
		return $this->waterItems;
	}

	public function getSodaItems(): int
	{
		return $this->sodaItems;
	}

	public function getJuiceItems(): int
	{
		return $this->juiceItems;
	}
}