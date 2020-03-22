<?php

namespace UserInput;

class UserInput
{
	protected $function;
	protected $arguments;

	public function __construct(string $function, array $arguments = [])
	{
		$function = trim($function);
		if ($function === '') {
			throw new \DomainException('Cannot use empty string as function');
		}

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

	/**
	 * Returns the input as string with function and arguments.
	 *
	 * @return string
	 */
	public function getInputString(): string
	{
		return $this->getFunction() . implode(',', $this->getArguments());
	}

	protected function sanitizeArguments(array $arguments): array
	{
		return array_map(function(string $argument) {
			return trim($argument);
		}, $arguments);
	}
}