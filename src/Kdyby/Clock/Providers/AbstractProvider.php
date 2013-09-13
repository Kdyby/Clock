<?php

/**
 * This file is part of the Kdyby (http://www.kdyby.org)
 *
 * Copyright (c) 2008 Filip Procházka (filip@prochazka.su)
 *
 * For the full copyright and license information, please view the file license.txt that was distributed with this source code.
 */

namespace Kdyby\Clock\Providers;

use Kdyby\Clock\IClock;
use Kdyby\Clock\IDateTimeProvider;
use Nette\Object;



/**
 * Base implementation for DateTime-based providers.
 * @author Michael Moravec
 */
abstract class AbstractProvider extends Object implements IDateTimeProvider
{
	/**
	 * @var \DateTime
	 */
	protected $prototype;



	public function __construct(\DateTime $prototype)
	{
		$this->prototype = $prototype;
	}



	/**
	 * {@inheritdoc}
	 */
	public function getDate()
	{
		$date = clone $this->prototype;
		$date->setTime(0, 0, 0);

		return $date;
	}



	/**
	 * {@inheritdoc}
	 */
	public function getTime()
	{
		return new \DateInterval(sprintf('PT%dH%dM%dS', $this->prototype->format('G'), $this->prototype->format('i'), $this->prototype->format('s')));
	}



	/**
	 * {@inheritdoc}
	 */
	public function getDateTime()
	{
		return clone $this->prototype;
	}



	/**
	 * {@inheritdoc}
	 */
	public function getTimezone()
	{
		return clone $this->prototype->getTimezone();
	}
}
