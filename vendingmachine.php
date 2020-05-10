#!/usr/bin/php
<?php

require __DIR__ . '/vendor/autoload.php';

$container = new DI\Container();

$shell = $container->get('App\UI\Console\Reader');
echo 'Starting Vending Machine Service...'.PHP_EOL;

while ($shell->readLine()) {
	if (!$shell->quitted()) {
		echo $shell->executeCommand().PHP_EOL;
	} else {
		break;
	}
}

echo 'Quitting Vending Machine service...'.PHP_EOL;