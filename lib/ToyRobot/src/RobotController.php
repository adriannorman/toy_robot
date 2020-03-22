<?php

namespace ToyRobot;

use ToyRobot\Exceptions\InvalidInputException;
use ToyRobot\Models\Robot;
use UserInput\UserInput;

/**
 * Class RobotController
 *
 * Provides client interface (via command line) for interacting with the domain.
 *
 * @package ToyRobot
 */
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
		// while (true) serves to constantly listen for user input

		while (true) {

			// halts the loop until after capturing client input
			$input = fgets(STDIN);

			try {

				$response = $this->robot->input(UserInput::makeFrom($input));

			} catch (InvalidInputException $e) {

				// application requires ignoring inputs (valid or invalid) until a valid 'PLACE' command.
				// logic/catch for this goes here as the model should still error on invalid command.

				$response = null;
			}

			// print response to client

			if (!is_null($response)) {
				echo $response;
			}
		}
	}
}