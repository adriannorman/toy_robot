<?php

namespace ToyRobot;

use ToyRobot\Models\Robot;
use UserInput\UserInput;


class RobotController
{
	/**
	 * @var Robot
	 */
	private $robot;

	/**
	 * RobotController constructor.
	 * @param Robot $robot
	 */
	public function __construct(Robot $robot)
	{
		$this->robot = $robot;
	}

	/**
	 * Listens for command line input.
	 */
	public function listen()
	{
		while (true) {

			$input = fgets(STDIN);
			$response = $this->robot->input(UserInput::makeFrom($input));

			if (!is_null($response)) {
				echo $response;
			}
		}
	}
}