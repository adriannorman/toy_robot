<?php

use PHPUnit\Framework\TestCase;

use ToyRobot\Models\Robot;
use ToyRobot\Exceptions\InvalidInputException;
use UserInput\UserInput;

class RobotInputTest extends TestCase
{
	/**
	 * @test
	 */
	public function robot_throws_exception_on_invalid_input(): void
	{
		$this->expectException(InvalidInputException::class);

		$robot = new Robot();
		$robot->input(UserInput::makeFrom('asfjkahgsdfkasdf'));
	}

	/**
	 * @test
	 */
	public function robot_accepts_valid_input(): void
	{
		$validInputs = [
			'PLACE 1,2,NORTH',
			'MOVE',
			'LEFT',
			'RIGHT',
			'REPORT'
		];

		$robot = new Robot();

		foreach ($validInputs as $input) {

			// expecting either null response for commands or strings for queries

			$this->assertIsString($robot->input(UserInput::makeFrom($input)) ?? '');
		}
	}

	/**
	 * @test
	 */
	public function unplaced_robot_reports_unplaced(): void
	{
		$robot = new Robot();
		$this->assertEquals('Unplaced', $robot->input(UserInput::makeFrom('REPORT')));
	}

	/**
	 * @test
	 */
	public function placed_robot_reports_state(): void
	{
		$robot = new Robot();

		$robot->input(UserInput::makeFrom('PLACE 3,2,EAST'));
		$report = $robot->input(UserInput::makeFrom('REPORT'));

		$this->assertEquals('3,2,EAST' . PHP_EOL, $report);
	}
}
