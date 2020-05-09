<?php

namespace Application\Services;

class CamelCaser
{
	public function __invoke(string $string): string
	{
		// non-alpha and non-numeric characters become spaces
        $string = preg_replace('/[^a-z0-9]+/i', ' ', $string);
        $string = strtolower(trim($string));

        $string = ucwords($string);
        $string = str_replace(" ", "", $string);

		return $string;
	}
}