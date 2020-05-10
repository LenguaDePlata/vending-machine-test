<?php

namespace App\Application\Commands;

interface Command {
	public function run(): string;
}