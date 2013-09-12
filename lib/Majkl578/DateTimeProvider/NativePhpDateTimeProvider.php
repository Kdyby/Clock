<?php

namespace Majkl578\DateTimeProvider;

/**
 * @author Michael Moravec
 */
class NativePhpDateTimeProvider extends AbstractDateTimeProvider
{
	public function __construct()
	{
		$this->prototype = new \DateTime();
	}
}
