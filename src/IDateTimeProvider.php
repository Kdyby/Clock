<?php

/**
 * This file is part of the Kdyby (http://www.kdyby.org)
 *
 * Copyright (c) 2008 Filip Procházka (filip@prochazka.su)
 *
 * For the full copyright and license information, please view the file license.txt that was distributed with this source code.
 */

namespace Kdyby\Clock;

interface IDateTimeProvider
{

	/**
	 * @return \DateTimeImmutable
	 */
	public function getDate();

	/**
	 * @return \DateInterval
	 */
	public function getTime();

	/**
	 * @return \DateTimeImmutable
	 */
	public function getDateTime();

	/**
	 * @return \DateTimeZone
	 */
	public function getTimezone();

}
