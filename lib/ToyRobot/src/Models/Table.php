<?php

namespace ToyRobot\Models;

use ToyRobot\Exceptions\TablePositionException;

/**
 * Class Table
 *
 * A plane upon which one implied entity can be positioned. Only one entity can sit on this plane.
 *
 * @package ToyRobot\Models
 */
class Table
{
	/**
	 * @var int
	 */
	protected $max_x;

	/**
	 * @var int
	 */
	protected $max_y;

	/**
	 * Table constructor.
	 *
	 * Method signature determines the width and depth of the table's plane.
	 *
	 * @param int $x
	 * @param int $y
	 */
	public function __construct(int $x, int $y)
	{
		$this->max_x = $x;
		$this->max_y = $y;
	}

	/**
	 * Returns the minimum x coordinate for this table's plane.
	 *
	 * @return int
	 */
	public function getMinX(): int
	{
		return 0;
	}

	/**
	 * Returns the maximum x coordinate for this table's plane.
	 *
	 * @return int
	 */
	public function getMaxX(): int
	{
		return $this->max_x;
	}

	/**
	 * Returns the minimum y coordinate for this table's plane.
	 *
	 * @return int
	 */
	public function getMinY(): int
	{
		return 0;
	}

	/**
	 * Returns the maximum y coordinate for this table's plane.
	 *
	 * @return int
	 */
	public function getMaxY(): int
	{
		return $this->max_y;
	}

	/**
	 * Returns the implied entity's coordinates on the table in the form of [x,y].
	 *
	 * A null return value communicates the implied entity has yet to be placed on the table.
	 *
	 * @return array|null
	 */
	public function getPosition(): ?array
	{
		return is_null($this->current_x) || is_null($this->current_y)
			? null
			: [$this->current_x, $this->current_y];
	}

	/**
	 * Sets the coordinates of the implied entity on the table.
	 *
	 * @param int $x
	 * @param int $y
	 */
	public function setPosition(int $x, int $y): void
	{
		if (!$this->isValidPosition($x, $y)) {
			throw new TablePositionException('Invalid Position: ' . $x . ',' . $y);
		}

		$this->current_x = $x;
		$this->current_y = $y;
	}

	/**
	 * Tells us whether or not a coordinate exists within the boundaries of this table's plane.
	 *
	 * @param int $x
	 * @param int $y
	 * @return bool
	 */
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