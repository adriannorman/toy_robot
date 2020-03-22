<?php

namespace ToyRobot;

class UserInput
{
	protected $function;
	protected $arguments;

	public function __construct(string $inputString)
	{
		$inputParts = explode(' ', trim($inputString));

		$this->function = array_shift($inputParts);
		$this->arguments = array_reduce(explode(',', implode(' ', $inputParts)), function(array $all, string $arg) {

			$trimmedArg = trim($arg);

			if ($trimmedArg !== '') {
				$all[] = $trimmedArg;
			}

			return $all;

		}, []);
	}

	public function getFunction(): string
	{
		return $this->function;
	}

	public function getArguments(): array
	{
		return $this->arguments;
	}
}