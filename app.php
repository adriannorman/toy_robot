<?php

require_once('./vendor/autoload.php');

use ToyRobot\Models\Robot;
use ToyRobot\RobotController;

echo 'Welcome to Toy Robot' . PHP_EOL;
(new RobotController(new Robot()))->listen();
