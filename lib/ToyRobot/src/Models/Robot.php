<?php

namespace ToyRobot\Models;

use ToyRobot\Exceptions\InvalidInputException;
use UserInput\AcceptsInput;
use UserInput\UserInput;

/**
 * Class Robot
 *
 * A robot that can navigate its way around a table. The robot "owns" the table, and thus is responsible
 * for moving itself around on it i.e. no external actor is required to handle this responsibility.
 *
 * @package ToyRobot\Models
 */
class Robot implements AcceptsInput
{
	PUBLIC CONST DIRECTION_NORTH = 'NORTH';
	PUBLIC CONST DIRECTION_SOUTH = 'SOUTH';
	PUBLIC CONST DIRECTION_EAST = 'EAST';
	PUBLIC CONST DIRECTION_WEST = 'WEST';

	/**
	 * The table on which the robot can be placed.
	 *
	 * @var Table
	 */
	protected $table;

	/**
	 * The direction in which the robot faces after being placed on the table.
	 *
	 * @var string
	 */
	protected $direction;

	/**
	 * Valid input command names that should have corresponding methods.
	 * The corresponding methods should not return anything.
	 *
	 * @var array
	 */
	protected $validCommands = [
		'PLACE',
		'MOVE',
		'LEFT',
		'RIGHT',
	];

	/**
	 * Valid input query names that should have corresponding methods.
	 * Methods should return values corresponding to the query request.
	 *
	 * @var array
	 */
	protected $validQueries = [
		'REPORT',
	];

	/**
	 * Robot constructor.
	 *
	 * Initializes with the table it can move around on as no external actor is required for this process.
	 */
	public function __construct()
	{
		$this->table = new Table(4, 4);
	}

	/**
	 * Responds to client input.
	 *
	 * Responsible for interfacing with the outside world.
	 * Commands return null, queries return strings.
	 *
	 * @param UserInput $input
	 * @return string|null
	 */
	public function input(UserInput $input): ?string
	{
		if (!$this->isValidInputFunction($input)) {
			throw new InvalidInputException('Invalid input: ' . $input->getInputString());
		}

		// ignore all inputs until the robot has been placed on table

		if (
			!$this->isPlacedWithDirection() &&
			$input->getFunction() !== 'PLACE'
		) {
			return null;
		}

		try {

			return call_user_func_array([$this, $input->getFunction()], $input->getArguments());

		} catch (\DomainException $e) {

			// treat business rule errors as invalid input errors if rules are broken due to user input

			throw new InvalidInputException('Invalid input: ' . $e->getMessage());
		}
	}

	/**
	 * Returns a list of valid command and query inputs.
	 *
	 * @return array
	 */
	private function getValidInputs(): array
	{
		return array_merge($this->validCommands, $this->validQueries);
	}

	/**
	 * Tests for whether or not input is a valid function.
	 *
	 * @param UserInput $input
	 * @return bool
	 */
	private function isValidInputFunction(UserInput $input): bool
	{
		return in_array($input->getFunction(), $this->getValidInputs());
	}


	// INPUT: COMMANDS

	/**
	 * Command to place the robot on the table.
	 *
	 * @param string $x
	 * @param string $y
	 * @param string $direction
	 */
	public function place(string $x, string $y, string $direction): void
	{
		$this->setPosition((int) $x, (int) $y);
		$this->setDirection($direction);
	}

	/**
	 * Command to advance a tabled robot by one in the direction it's facing.
	 */
	public function move(): void
	{
		$position = $this->getPosition();
		if (is_null($position)) {
			throw new \DomainException('Cannot move robot without position');
		}

		$x = $position[0];
		$y = $position[1];

		switch ($this->getDirection()) {

			case self::DIRECTION_NORTH:
				$this->setPosition($x, $y + 1);
				break;

			case self::DIRECTION_EAST:
				$this->setPosition($x + 1, $y);
				break;

			case self::DIRECTION_SOUTH:
				$this->setPosition($x, $y - 1);
				break;

			case self::DIRECTION_WEST:
				$this->setPosition($x - 1, $y);
				break;

			default:
				throw new \DomainException('Cannot move robot without direction');
		}
	}

	/**
	 * Command to turn the robot's direction by 90 degrees left.
	 */
	public function left(): void
	{
		$this->turnOnce(-1);
	}

	/**
	 * Command to turn the robot's direction by 90 degrees right.
	 */
	public function right(): void
	{
		$this->turnOnce(1);
	}


	// INPUT: QUERIES

	/**
	 * Command to report on the robot's state upon the table.
	 *
	 * @return string|null
	 */
	protected function report(): ?string
	{
		if (!$this->isPlacedWithDirection()) {
			return null;
		}

		return implode(',', [
			implode(',', $this->getPosition()),
			$this->direction
		]) . PHP_EOL;
	}


	// DOMAIN LOGIC

	/**
	 * Gets the robot's position on the table in the form of [x,y]
	 *
	 * @return array|null
	 */
	public function getPosition(): ?array
	{
		return $this->table->getPosition();
	}

	/**
	 * Sets the robot's position on its table.
	 *
	 * @param int $x
	 * @param int $y
	 */
	public function setPosition(int $x, int $y): void
	{
		$this->table->setPosition($x, $y);
	}

	/**
	 * Gets the direction the robot is facing after being placed on its table.
	 *
	 * @return string|null
	 */
	public function getDirection(): ?string
	{
		return $this->direction;
	}

	/**
	 * Sets the direction the robot is facing on its table.
	 *
	 * @param string $direction
	 */
	public function setDirection(string $direction): void
	{
		if (!in_array(
			$direction,
			[
				self::DIRECTION_NORTH,
				self::DIRECTION_SOUTH,
				self::DIRECTION_WEST,
				self::DIRECTION_EAST,
			]
		)) {
			throw new \DomainException('Direction must either be "NORTH", "SOUTH", "EAST" or "WEST"');
		}

		$this->direction = $direction;
	}

	/**
	 * Convenience method to check that the robot has both a position on and direction relative to its table.
	 *
	 * @return bool
	 */
	public function isPlacedWithDirection(): bool
	{
		return $this->table->getPosition() && $this->getDirection();
	}

	/**
	 * Turns the robot 90 degrees either clockwise or counterclockwise.
	 *
	 * A positive integer turns the robot clockwise, a negative one turns it counterclockwise. No matter the
	 * absolute value of the integer, the robot is limited to turning 90 degrees in either direction per call.
	 *
	 * @param int $direction
	 */
	protected function turnOnce(int $direction): void
	{
		if (is_null($this->getDirection())) {
			throw new \DomainException('Cannot turn robot without direction');
		}

		$orderedDirections = [
			self::DIRECTION_NORTH,
			self::DIRECTION_EAST,
			self::DIRECTION_SOUTH,
			self::DIRECTION_WEST,
		];

		// ensure we only advance 1 step positively or negatively
		$direction = $direction <=> 0;
		$currentDirectionIndex = array_search($this->getDirection(), $orderedDirections);

		if ($currentDirectionIndex === 0 && $direction === -1) {
			$this->setDirection(array_pop($orderedDirections));
		} elseif ($currentDirectionIndex === count($orderedDirections) - 1 && $direction === 1) {
			$this->setDirection(array_shift($orderedDirections));
		} else {
			$this->setDirection($orderedDirections[$currentDirectionIndex + $direction]);
		}
	}
}
