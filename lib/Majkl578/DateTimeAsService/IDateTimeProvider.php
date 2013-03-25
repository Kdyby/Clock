<?php

namespace Majkl578\DateTimeAsService;

/**
 * @author Michael Moravec
 */
interface IDateTimeProvider
{
	/**
	 * @return \DateTime
	 */
	function getDateTimePrototype();
}
