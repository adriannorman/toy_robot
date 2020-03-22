<?php

use UserInput\UserInput;
use PHPUnit\Framework\TestCase;

class UserInputTest extends TestCase
{
	/**
	 * @test
	 */
	public function can_create_with_function_and_arguments(): void
	{
		$input = new UserInput('function_string', ['argument_1', 'argument_2']);

		$this->assertEquals('function_string', $input->getFunction());
		$this->assertEquals(['argument_1', 'argument_2'], $input->getArguments());
	}
}
