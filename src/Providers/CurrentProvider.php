<?php

/**
 * This file is part of the Kdyby (http://www.kdyby.org)
 *
 * Copyright (c) 2008 Filip Procházka (filip@prochazka.su)
 *
 * For the full copyright and license information, please view the file license.txt that was distributed with this source code.
 */

namespace Kdyby\Clock\Providers;

use DateInterval;
use DateTimeImmutable;
use DateTimeZone;

class CurrentProvider implements \Kdyby\Clock\IDateTimeProvider
{

	use \Kdyby\StrictObjects\Scream;

	/**
	 * {@inheritdoc}
	 */
	public function getDate()
	{
		return $this->getDateTime()->setTime(0, 0, 0);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getTime()
	{
		$now = $this->getDateTime();
		return new DateInterval(sprintf('PT%dH%dM%dS', $now->format('G'), $now->format('i'), $now->format('s')));
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDateTime()
	{
		return new DateTimeImmutable();
	}

	/**
	 * {@inheritdoc}
	 */
	public function getTimezone()
	{
		return new DateTimeZone(date_default_timezone_get());
	}

}
