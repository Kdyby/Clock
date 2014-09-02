<?php

/**
 * This file is part of the Kdyby (http://www.kdyby.org)
 *
 * Copyright (c) 2008 Filip Procházka (filip@prochazka.su)
 *
 * For the full copyright and license information, please view the file license.txt that was distributed with this source code.
 */

namespace Kdyby\Clock;

use Kdyby;
use Nette;
use Traversable;



/**
 * @author Filip Procházka <filip@prochazka.su>
 * @author Alexey Shockov <alexey@shockov.com>
 * @author Vyacheslav Salakhutdinov megazoll <megazoll@gmail.com>
 */
class Period extends Nette\Object implements \IteratorAggregate
{

	/**
	 * @var DateTime
	 */
	private $start;

	/**
	 * @var DateTime
	 */
	private $end;

	/**
	 * @var Interval
	 */
	private $interval;

	/**
	 * @var \DatePeriod
	 */
	private $period;



	/**
	 * Params are equal to original constructor.
	 *
	 * @throws \InvalidArgumentException
	 */
	public function __construct()
	{
		$args = func_get_args();

		if (in_array(func_num_args(), array(3, 4))) {
			$this->interval = new Interval($args[1]);
		}

		if (in_array(func_num_args(), array(1, 2))) {
			$this->interval = $this->getIntervalFromString($args[0]);
		}

		switch (func_num_args()) {
			case 1:
				$this->period = new \DatePeriod($args[0]);
				break;
			case 2:
				$this->period = new \DatePeriod($args[0], $args[1]);
				break;
			case 3:
				$this->period = new \DatePeriod($args[0], $args[1], $args[2]);
				break;
			case 4:
				$this->period = new \DatePeriod($args[0], $args[1], $args[2], $args[3]);
				break;
			case 5:
				$this->period = new \DatePeriod($args[0], $args[1], $args[2], $args[3], $args[5]);
				break;
		}
	}



	/**
	 * Determines interval from ISO formatted string period string.
	 *
	 * @param string $string
	 * @throws InvalidArgumentException
	 * @return \DateInterval
	 */
	private function getIntervalFromString($string)
	{
		$parts = explode('/', $string);

		foreach ($parts as $part) {
			if (0 === strpos($part, 'P')) {
				return new Interval($part);
			}
		}

		throw new InvalidArgumentException('Unable to get interval from string.');
	}



	/**
	 * @return DateTime
	 */
	public function getStart()
	{
		if (!$this->start) {
			foreach ($this->period as $start) {
				$this->start = new Precision\Second($start);

				break;
			}
		}

		return $this->start;
	}



	/**
	 * @todo Determine from constructor.
	 *
	 * @return DateTime
	 */
	public function getEnd()
	{
		if (!$this->end) {
			$end = null;
			foreach ($this->period as $end) {

			}

			$this->end = new Precision\Second($end);
		}

		return $this->end;
	}



	/**
	 * @return Interval
	 */
	public function getInterval()
	{
		return $this->interval;
	}



	/**
	 * @param \DateTime $dt
	 *
	 * @return bool
	 */
	public function contains(\DateTime $dt)
	{
		return (($dt >= $this->getStart()) && ($dt <= $this->getEnd()));
	}



	/**
	 * ISO period string.
	 *
	 * @return string
	 */
	public function __toString()
	{
		$string = $this->getStart() . '/' . $this->getInterval() . '/' . $this->getEnd();

		// TODO Replace this shit...
		return str_replace('+00:00', 'Z', $string);
	}



	/**
	 * @return Traversable
	 */
	public function getIterator()
	{
		return $this->period;
	}



	/**
	 * By default — for current month.
	 *
	 * @param \DateTime|null $month
	 */
	public static function forMonth(\DateTime $month = null)
	{
		if (!$month) {
			$month = new \DateTime();
		}

		$startDate = \DateTime::createFromFormat('Y-m-d H:i:s', $month->format('Y-m-01 00:00:00'));
		// Дата окончания включается исключительно, нужно сделать дополнительный день, чтобы получить её в периоде.
		$endDate = \DateTime::createFromFormat('Y-m-d H:i:s', $month->format('Y-m-t 00:00:00'))->modify('+1 day');

		return new static($startDate, new \DateInterval('P1D'), $endDate);
	}



	/**
	 * By default — for current week.
	 *
	 * @param \DateTime|null $monday
	 */
	public static function forWeek(\DateTime $monday = null)
	{
		if (!$monday) {
			$currentDay = new \DateTime();
			$monday = $currentDay->modify('-' . ($currentDay->format('N') - 1) . ' day');
		}

		$startDate = \DateTime::createFromFormat('Y-m-d H:i:s', $monday->format('Y-m-d 00:00:00'));
		$endDate = clone $startDate;
		// We must add one more day to include end date in period.
		$endDate = $endDate->modify('+6 days')->modify('+1 day');

		return new static($startDate, new \DateInterval('P1D'), $endDate);
	}

}
