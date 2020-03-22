<?php

namespace UserInput;

class UserInput
{
	protected $function;
	protected $arguments;

	public function __construct(string $function, array $arguments = [])
	{
		$this->function = $function;
		$this->arguments = $this->sanitizeArguments($arguments);

	}

	/**
	 * Factory method to create a new instance from an input string.
	 *
	 * @param string $inputString
	 * @return UserInput
	 */
	public static function makeFrom(string $inputString): UserInput
	{
		$inputParts = explode(' ', trim($inputString));

		$function = array_shift($inputParts);
		$arguments = explode(',', implode(' ', $inputParts));

		return new UserInput($function, $arguments);
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