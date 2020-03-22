<?php

namespace ToyRobot;

use ToyRobot\Exceptions\InvalidInputException;
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

			try {

				$response = $this->robot->input(UserInput::makeFrom($input));

			} catch (InvalidInputException $e) {

				// application requires ignoring inputs (valid or invalid) until a valid 'PLACE' command.
				// logic/catch for this goes here as the model should still error on invalid command.

				$response = null;
			}

			if (!is_null($response)) {
				echo $response;
			}
		}
	}
}