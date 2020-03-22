<?php

require_once('./vendor/autoload.php');

use ToyRobot\Robot;

$robot = new Robot();

echo 'Welcome to Toy Robot' . PHP_EOL;

while (true) {

	$input = fgets(STDIN);
	$response = $robot->input($input);

	if (!is_null($response)) {
		echo $response;
	}
}
