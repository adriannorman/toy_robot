<?php

use UserInput\UserInput;
use PHPUnit\Framework\TestCase;

class UserInputTest extends TestCase
{
	/**
	 * @test
	 */
	public function can_construct_with_function_and_arguments(): void
	{
		$input = new UserInput('function_string', ['argument_1', 'argument_2']);

		$this->assertEquals('function_string', $input->getFunction());
		$this->assertEquals(['argument_1', 'argument_2'], $input->getArguments());
	}

	/**
	 * @test
	 */
	public function cannot_construct_with_empty_function(): void
	{
		$this->expectException(\DomainException::class);
		$this->expectExceptionMessage('Cannot use empty string as function');

		$input = new UserInput('');
	}

	/**
	 * @test
	 */
	public function can_make_from_input_string(): void
	{
		$input = UserInput::makeFrom('function arg_1,arg_2');

		$this->assertEquals('function', $input->getFunction());
		$this->assertEquals(['arg_1', 'arg_2'], $input->getArguments());
	}
}
