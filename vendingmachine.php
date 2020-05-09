#!/usr/bin/php
<?php

require 'autoloader.php';

$shell = \UI\Console\ReaderBuilder::build();
echo 'Starting Vending Machine Service...'.PHP_EOL;

while ($shell->readLine()) {
	if (!$shell->quitted()) {
		echo $shell->executeCommand().PHP_EOL;
	} else {
		break;
	}
}

echo 'Quitting Vending Machine service...'.PHP_EOL;