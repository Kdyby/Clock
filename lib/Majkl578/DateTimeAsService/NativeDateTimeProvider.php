<?php

namespace Majkl578\DateTimeAsService;

/**
 * @author Michael Moravec
 */
class NativeDateTimeProvider extends AbstractDateTimeProvider
{
	public function __construct()
	{
		$this->dateTimePrototype = new \DateTime();
	}
}
