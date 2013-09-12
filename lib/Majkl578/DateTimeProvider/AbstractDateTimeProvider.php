<?php

namespace Majkl578\DateTimeProvider;

use Nette\Object;

/**
 * Base implementation for DateTime-based providers.
 * @author Michael Moravec
 */
class AbstractDateTimeProvider extends Object implements IDateTimeProvider
{
	/** @var \DateTime */
	protected $prototype;

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
