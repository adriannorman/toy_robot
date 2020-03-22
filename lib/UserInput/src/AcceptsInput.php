<?php

namespace UserInput;

interface AcceptsInput
{
	/**
	 * Responds to client input.
	 *
	 * @param UserInput $input
	 * @return string|null
	 */
	public function input(UserInput $input): ?string;
}