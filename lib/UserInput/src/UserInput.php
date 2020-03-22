<?php

namespace UserInput;

class UserInput
{
	protected $function;
	protected $arguments;

	public function __construct(string $function, array $arguments = [])
	{
//		$inputParts = explode(' ', trim($inputString));

		$this->function = $function;
		$this->arguments = $this->sanitizeArguments($arguments);
//		$this->arguments = array_reduce(explode(',', implode(' ', $inputParts)), function(array $all, string $arg) {
//
//			$trimmedArg = trim($arg);
//
//			if ($trimmedArg !== '') {
//				$all[] = $trimmedArg;
//			}
//
//			return $all;
//
//		}, []);
	}

	public function getFunction(): string
	{
		return $this->function;
	}

	public function getArguments(): array
	{
		return $this->arguments;
	}

	protected function sanitizeArguments(array $arguments): array
	{
		return array_map(function(string $argument) {
			return trim($argument);
		}, $arguments);
	}
}