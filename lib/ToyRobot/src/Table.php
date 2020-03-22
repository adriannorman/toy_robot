<?php

namespace ToyRobot;

use ToyRobot\Exceptions\TablePositionException;


class Table
{
	protected $max_x;
	protected $max_y;

	protected $current_x;
	protected $current_y;

	public function __construct(int $x, int $y)
	{
		$this->max_x = $x;
		$this->max_y = $y;
	}

	public function getMinX(): int
	{
		return 0;
	}

	public function getMaxX(): int
	{
		return $this->max_x;
	}

	public function getMinY(): int
	{
		return 0;
	}

	public function getMaxY(): int
	{
		return $this->max_y;
	}

	public function getPosition(): ?array
	{
		return is_null($this->current_x) || is_null($this->current_y)
			? null
			: [$this->current_x, $this->current_y];
	}

	public function setPosition(int $x, int $y): void
	{
		if (!$this->isValidPosition($x, $y)) {
			throw new TablePositionException('Invalid Position: ' . $x . ',' . $y);
		}

		$this->current_x = $x;
		$this->current_y = $y;
	}

	protected function isValidPosition(int $x, int $y): bool
	{
		if (
			$x >= $this->getMinX() &&
			$x <= $this->getMaxX() &&
			$y >= $this->getMinY() &&
			$y <= $this->getMaxY()
		) {
			return true;
		}

		return false;
	}
}