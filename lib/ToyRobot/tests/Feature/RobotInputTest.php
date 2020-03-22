<?php

use PHPUnit\Framework\TestCase;

use ToyRobot\Models\Robot;
use ToyRobot\Exceptions\InvalidInputException;

class RobotInputTest extends TestCase
{
	/**
	 * @test
	 */
	public function robot_throws_exception_on_invalid_input(): void
	{
		$this->expectException(InvalidInputException::class);

		$robot = new Robot();
		$robot->input('asfjkahgsdfkasdf');
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

			$this->assertIsString($robot->input($input) ?? '');
		}
	}

	/**
	 * @test
	 */
	public function unplaced_robot_reports_unplaced(): void
	{
		$robot = new Robot();
		$this->assertEquals('Unplaced', $robot->input('REPORT'));
	}

	/**
	 * @test
	 */
	public function placed_robot_reports_state(): void
	{
		$robot = new Robot();

		$robot->input('PLACE 3,2,EAST');
		$report = $robot->input('REPORT');

		$this->assertEquals('3,2,EAST', $report);
	}
}
