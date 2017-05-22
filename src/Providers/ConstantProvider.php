<?php

/**
 * This file is part of the Kdyby (http://www.kdyby.org)
 *
 * Copyright (c) 2008 Filip Procházka (filip@prochazka.su)
 *
 * For the full copyright and license information, please view the file license.txt that was distributed with this source code.
 */

namespace Kdyby\Clock\Providers;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;

class ConstantProvider extends \Kdyby\Clock\Providers\AbstractProvider
{

	/**
	 * @param string|int|\DateTimeInterface $dateTime
	 */
	public function __construct($dateTime)
	{
		if ($dateTime instanceof DateTimeInterface) {
			if ($dateTime instanceof DateTime) {
				$dateTime = DateTimeImmutable::createFromMutable($dateTime);
			}
			if (!$dateTime instanceof DateTimeImmutable) {
				throw new \Kdyby\Clock\InvalidArgumentException(sprintf('ConstantProvider requires DateTimeImmutable instance, but %s given', get_class($dateTime)));
			}
			parent::__construct($dateTime);

		} elseif (is_numeric($dateTime)) {
			parent::__construct(new DateTimeImmutable(date('Y-m-d H:i:s', $dateTime), new DateTimeZone(date_default_timezone_get())));

		} elseif (is_string($dateTime)) {
			throw new \Kdyby\Clock\NotImplementedException(sprintf(
				'Cannot process datetime in given format "%s"',
				$dateTime
			));

		} else {
			throw new \Kdyby\Clock\NotImplementedException(sprintf(
				'Cannot process datetime from given value %s',
				is_object($dateTime) ? get_class($dateTime) : gettype($dateTime)
			));
		}
	}

}
