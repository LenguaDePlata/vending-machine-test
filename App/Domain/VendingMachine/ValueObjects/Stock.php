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
		$this->waterItems = $waterItems;
		$this->sodaItems = $sodaItems;
		$this->juiceItems = $juiceItems;
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