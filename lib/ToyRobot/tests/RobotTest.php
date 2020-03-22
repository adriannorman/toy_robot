<?php

use PHPUnit\Framework\TestCase;

use ToyRobot\Robot;

class RobotTest extends TestCase
{
	/**
	 * @test
	 */
	public function cannot_turn_robot_left_without_direction(): void
	{
		$this->expectException(\DomainException::class);
		$this->expectExceptionMessage('Cannot turn robot without direction');

		$robot = new Robot();
		$this->assertNull($robot->getDirection());

		$robot->left();
	}

	/**
	 * @test
	 */
	public function turning_robot_changes_direction(): void
	{
		$robot = new Robot();

		$robot->setDirection(Robot::DIRECTION_NORTH);

		$robot->left();
		$this->assertEquals(Robot::DIRECTION_WEST, $robot->getDirection());

		$robot->left();
		$this->assertEquals(Robot::DIRECTION_SOUTH, $robot->getDirection());

		$robot->left();
		$this->assertEquals(Robot::DIRECTION_EAST, $robot->getDirection());

		$robot->left();
		$this->assertEquals(Robot::DIRECTION_NORTH, $robot->getDirection());

		$robot->right();
		$this->assertEquals(Robot::DIRECTION_EAST, $robot->getDirection());

		$robot->right();
		$this->assertEquals(Robot::DIRECTION_SOUTH, $robot->getDirection());

		$robot->right();
		$this->assertEquals(Robot::DIRECTION_WEST, $robot->getDirection());

		$robot->right();
		$this->assertEquals(Robot::DIRECTION_NORTH, $robot->getDirection());
	}

	/**
	 * @test
	 */
	public function cannot_turn_robot_right_without_direction(): void
	{
		$this->expectException(\DomainException::class);
		$this->expectExceptionMessage('Cannot turn robot without direction');

		$robot = new Robot();
		$this->assertNull($robot->getDirection());

		$robot->right();
	}

	/**
	 * @test
	 */
	public function robot_without_direction_cannot_move(): void
	{
		$this->expectException(\DomainException::class);
		$this->expectExceptionMessage('Cannot move robot without direction');

		$robot = new Robot();
		$robot->setPosition(0, 0);

		$this->assertEquals([0, 0], $robot->getPosition());
		$this->assertNull($robot->getDirection());
		$robot->move();
	}

	/**
	 * @test
	 */
	public function robot_without_position_cannot_move(): void
	{
		$this->expectException(\DomainException::class);
		$this->expectExceptionMessage('Cannot move robot without position');

		$robot = new Robot();
		$robot->setDirection(Robot::DIRECTION_NORTH);

		$this->assertEquals(Robot::DIRECTION_NORTH, $robot->getDirection());
		$this->assertNull($robot->getPosition());
		$robot->move();
	}

	/**
	 * @test
	 */
	public function moving_robot_advances_one_step_in_direction(): void
	{
		$robot = new Robot();

		// north

		$robot->setDirection(Robot::DIRECTION_NORTH);
		$robot->setPosition(0, 0);

		$robot->move();

		$this->assertEquals([0, 1], $robot->getPosition());

		// south

		$robot->setDirection(Robot::DIRECTION_SOUTH);
		$robot->setPosition(4, 4);

		$robot->move();

		$this->assertEquals([4, 3], $robot->getPosition());

		// east

		$robot->setDirection(Robot::DIRECTION_EAST);
		$robot->setPosition(0, 0);

		$robot->move();

		$this->assertEquals([1, 0], $robot->getPosition());

		// west

		$robot->setDirection(Robot::DIRECTION_WEST);
		$robot->setPosition(4, 4);

		$robot->move();

		$this->assertEquals([3, 4], $robot->getPosition());
	}
}
