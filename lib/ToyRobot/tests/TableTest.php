<?php

use ToyRobot\Exceptions\TablePositionException;
use ToyRobot\Table;

class TableTest extends PHPUnit\Framework\TestCase
{
	/**
	 * @test
	 */
	public function can_create_table_with_boundaries(): void
	{
		$table = new Table(8, 7);

		$this->assertEquals(0, $table->getMinX());
		$this->assertEquals(0, $table->getMinY());

		$this->assertEquals(8, $table->getMaxX());
		$this->assertEquals(7, $table->getMaxY());
	}

	/**
	 * @test
	 */
	public function can_set_valid_position(): void
	{
		$table = new Table(4, 4);
		$table->setPosition(2, 3);

		$this->assertEquals([2, 3], $table->getPosition());
	}

	/**
	 * @test
	 */
	public function cannot_set_invalid_position(): void
	{
		$this->expectException(TablePositionException::class);

		$table = new Table(4,4);
		$table->setPosition(6, 3);
	}
}