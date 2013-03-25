<?php

namespace Majkl578\DateTimeAsService;

/**
 * @author Michael Moravec
 */
abstract class AbstractDateTimeProvider implements IDateTimeProvider
{
	/** @var \DateTime */
	protected $dateTimePrototype;

	public function __construct()
	{
		throw new \LogicException('Not implemented.');
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDateTimePrototype()
	{
		return clone $this->dateTimePrototype;
	}
}
