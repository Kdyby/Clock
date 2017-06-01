<?php

/**
 * This file is part of the Kdyby (http://www.kdyby.org)
 *
 * Copyright (c) 2008 Filip Procházka (filip@prochazka.su)
 *
 * For the full copyright and license information, please view the file license.txt that was distributed with this source code.
 */

namespace Kdyby\DateTimeProvider\Provider;

use DateInterval;
use DateTimeImmutable;
use DateTimeZone;

/**
 * Provides some optimizations for providers with guaranteed immutability.
 */
trait ImmutableProviderTrait
{

	use \Kdyby\DateTimeProvider\Provider\ProviderTrait {
		getDate as getDateVolatile;
		getTime as getTimeVolatile;
		getTimezone as getTimezoneVolatile;
		getPrototype as getDateTime;
	}

	/**
	 * Cached date immutable object (time 0:00:00)
	 *
	 * @var \DateTimeImmutable|NULL
	 */
	private $date;

	/**
	 * Cached time object
	 *
	 * @var \DateTimeImmutable|NULL
	 */
	private $time;

	/**
	 * Cached time zone object
	 *
	 * @var \DateTimeZone|NULL
	 */
	private $timezone;

	public function getDate(): DateTimeImmutable
	{
		if ($this->date === NULL) {
			$this->date = $this->getDateVolatile();
		}

		return $this->date;
	}

	public function getTime(): DateInterval
	{
		if ($this->time === NULL) {
			$this->time = $this->getTimeVolatile();
		}

		if (PHP_VERSION_ID >= 70107) {
			// DateInterval cloning support added in PHP 7.1.7
			// https://github.com/php/php-src/commit/48598a23024eb587127b59bf0490891addfc41ed
			return clone $this->time;
		}

		return new DateInterval(sprintf('PT%dH%dM%dS', $this->time->h, $this->time->i, $this->time->s));
	}

	public function getTimezone(): DateTimeZone
	{
		if ($this->timezone === NULL) {
			$this->timezone = $this->getTimezoneVolatile();
		}

		return $this->timezone;
	}

}
