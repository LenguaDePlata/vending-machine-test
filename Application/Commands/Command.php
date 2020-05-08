<?php

namespace Application\Commands;

interface Command {
	public function run(): string;
}