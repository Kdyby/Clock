<?php

/**
 * This file is part of the Kdyby (http://www.kdyby.org)
 *
 * Copyright (c) 2008 Filip Procházka (filip@prochazka.su)
 *
 * For the full copyright and license information, please view the file license.txt that was distributed with this source code.
 */

namespace Kdyby\Clock;



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
