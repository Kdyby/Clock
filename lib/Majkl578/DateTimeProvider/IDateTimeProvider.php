<?php

namespace Majkl578\DateTimeProvider;

/**
 * @author Michael Moravec
 */
interface IDateTimeProvider
{
	/**
	 * @return \DateTime|\DateTimeInterface
	 */
	function getDate();

	/**
	 * @return \DateInterval
	 */
	function getTime();

	/**
	 * @return \DateTime|\DateTimeInterface
	 */
	function getDateTime();

	/**
	 * @return \DateTimeZone
	 */
	function getTimezone();
}
