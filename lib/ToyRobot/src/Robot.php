<?php

namespace ToyRobot;

use ToyRobot\Exceptions\InvalidInputException;

class Robot
{
	PUBLIC CONST DIRECTION_NORTH = 'NORTH';
	PUBLIC CONST DIRECTION_SOUTH = 'SOUTH';
	PUBLIC CONST DIRECTION_EAST = 'EAST';
	PUBLIC CONST DIRECTION_WEST = 'WEST';

	protected $table;

	protected $direction;

	protected $validCommands = [
		'PLACE',
		'MOVE',
		'LEFT',
		'RIGHT',
	];

	protected $validQueries = [
		'REPORT',
	];

	public function __construct()
	{
		$this->table = new Table(4, 4);
	}

	public function input(string $input): ?string
	{
		$userInput = new UserInput($input);

		if (!$this->isValidInputFunction($userInput)) {
			throw new InvalidInputException('Invalid input: ' . $input);
		}

		return call_user_func_array([$this, $userInput->getFunction()], $userInput->getArguments());
	}

	private function getValidInputs(): array
	{
		return array_merge($this->validCommands, $this->validQueries);
	}

	private function isValidInputFunction(UserInput $input): bool
	{
		return in_array($input->getFunction(), $this->getValidInputs());
	}


	// INPUT: COMMANDS

	public function place(string $x, string $y, string $direction): void
	{
		$this->setPosition((int) $x, (int) $y);
		$this->setDirection($direction);
	}

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

	public function left(): void
	{
		$this->turnOnce(-1);
	}

	public function right(): void
	{
		$this->turnOnce(1);
	}


	// INPUT: QUERIES

	protected function report(): string
	{
		if (!$this->isPlaced()) {
			return 'Unplaced';
		}

		return implode(',', [
			implode(',', $this->getPosition()),
			$this->direction
		]) . PHP_EOL;
	}


	// DOMAIN LOGIC

	public function getPosition(): ?array
	{
		return $this->table->getPosition();
	}

	public function setPosition(int $x, int $y): void
	{
		$this->table->setPosition($x, $y);
	}

	public function getDirection(): ?string
	{
		return $this->direction;
	}

	public function setDirection(string $direction): void
	{
		$this->direction = $direction;
	}

	public function isPlaced(): bool
	{
		return $this->table->getPosition() ? true : false;
	}

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