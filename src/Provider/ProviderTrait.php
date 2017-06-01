<?php

/**
 * This file is part of the Kdyby (http://www.kdyby.org)
 *
 * Copyright (c) 2008 Filip Procházka (filip@prochazka.su)
 *
 * For the full copyright and license information, please view the file license.txt that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Kdyby\DateTimeProvider\Provider;

use DateInterval;
use DateTimeImmutable;
use DateTimeZone;

/**
 * Base implementation for DateTime-based providers.
 */
trait ProviderTrait
{

	abstract protected function getPrototype(): DateTimeImmutable;

	/**
	 * {@inheritdoc}
	 */
	public function getDate(): DateTimeImmutable
	{
		return $this->getPrototype()->setTime(0, 0, 0);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getTime(): DateInterval
	{
		return new DateInterval(sprintf('PT%dH%dM%dS', $this->getPrototype()->format('G'), $this->getPrototype()->format('i'), $this->getPrototype()->format('s')));
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDateTime(): DateTimeImmutable
	{
		return $this->getPrototype();
	}

	/**
	 * {@inheritdoc}
	 */
	public function getTimezone(): DateTimeZone
	{
		return $this->getPrototype()->getTimezone();
	}

}
