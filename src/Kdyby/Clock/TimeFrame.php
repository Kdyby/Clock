<?php

/**
 * This file is part of the Kdyby (http://www.kdyby.org)
 *
 * Copyright (c) 2008 Filip Procházka (filip@prochazka.su)
 *
 * For the full copyright and license information, please view the file license.txt that was distributed with this source code.
 */

namespace Kdyby\Clock;

use DateInterval;
use DateTimeZone;
use Kdyby;
use Nette;
use Symfony\Component\Validator\Constraints\Time;



/**
 * @author Filip Procházka <filip@prochazka.su>
 * @author Alexey Shockov <alexey@shockov.com>
 * @author Vyacheslav Salakhutdinov megazoll <megazoll@gmail.com>
 *
 * @property-read DateTimeZone $timezone
 * @property-read bool $leapYear
 * @property-read bool $inTheFuture
 * @property-read int $year
 * @property-read int $month
 * @property-read int $day
 * @property-read int $dayOfYear
 * @property-read int $dayOfWeek
 * @property-read int $hour
 * @property-read int $minute
 * @property-read int $second
 */
abstract class TimeFrame extends Nette\DateTime implements DateTime
{

	/**
	 * @var string
	 */
	private $precision;



	public function __construct($precision, $time = 'now', DateTimeZone $timezone = null)
	{
		$this->precision = $precision;

		$beforeErrors = $this->getLastErrors();

		if ($time instanceof \DateTime || $time instanceof \DateTimeInterface) {
			parent::__construct($time->format($this->precision), $timezone ?: $time->getTimezone());

		} elseif (is_numeric($time)) {
			if ($time <= self::YEAR) {
				$time += time();
			}

			parent::__construct(date($this->precision, $time), $timezone);

		} else {
			parent::__construct($time, $timezone);
		}

		$afterErrors = $this->getLastErrors();

		if ($afterErrors['error_count'] > $beforeErrors['error_count']) {
			throw new InvalidArgumentException(array_shift($afterErrors['errors']));
		}

		if ($afterErrors['warning_count'] > $beforeErrors['warning_count']) {
			throw new InvalidArgumentException(array_shift($afterErrors['warnings']));
		}
	}



	/**
	 * @param string $modify
	 * @return TimeFrame
	 */
	public function modify($modify)
	{
		$dt = new \DateTime((string) $this, $this->getTimezone());
		return self::determinePrecision($dt->modify($modify));
	}



	/**
	 * @param DateInterval $interval
	 * @return TimeFrame
	 */
	public function add($interval)
	{
		$dt = new \DateTime((string) $this, $this->getTimezone());
		return self::determinePrecision($dt->add($interval));
	}



	/**
	 * @param DateInterval $interval
	 * @return TimeFrame
	 */
	public function sub($interval)
	{
		$dt = new \DateTime((string) $this, $this->getTimezone());
		return self::determinePrecision($dt->sub($interval));
	}



	/**
	 * @param \DateTime $timeFrame
	 * @param bool $absolute
	 *
	 * @return Interval
	 */
	public function diff($timeFrame, $absolute = null)
	{
		return new Interval(parent::diff($timeFrame, $absolute));
	}



	/**
	 * @return DateTimeZone
	 */
	public function getTimezone()
	{
		return parent::getTimezone();
	}



	/**
	 * @param DateTimeZone $timezone
	 * @return TimeFrame
	 */
	public function setTimezone($timezone)
	{
		$dt = new \DateTime((string) $this, $this->getTimezone());
		return new static($dt->setTimezone($timezone));
	}



	/**
	 * @param int $hour
	 * @param int $minute
	 * @param int $second
	 * @throws Kdyby\Clock\Exception
	 * @return TimeFrame
	 */
	public function setTime($hour, $minute, $second = 0)
	{
		$dt = new \DateTime((string) $this, $this->getTimezone());
		return self::determinePrecision($dt->setTime($hour, $minute, $second));
	}



	/**
	 * @param int $year
	 * @param int $month
	 * @param int $day
	 * @return TimeFrame
	 */
	public function setDate($year, $month, $day)
	{
		$dt = new \DateTime((string) $this, $this->getTimezone());
		return self::determinePrecision($dt->setDate($year, $month, $day));
	}



	/**
	 * @param int $year
	 * @param int $week
	 * @param int $day
	 * @return TimeFrame
	 */
	public function setISODate($year, $week, $day = 1)
	{
		$dt = new \DateTime((string) $this, $this->getTimezone());
		return self::determinePrecision($dt->setISODate($year, $week, $day));
	}



	/**
	 * @param int $unixtime
	 * @return TimeFrame
	 */
	public function setTimestamp($unixtime)
	{
		$dt = new \DateTime((string) $this, $this->getTimezone());
		return self::determinePrecision($dt->setTimestamp($unixtime));
	}



	public function __toString()
	{
		return parent::format($this->precision);
	}



	/**
	 * @param mixed $timeFrame
	 *
	 * @return bool
	 */
	public function isEqualTo($timeFrame)
	{
		if ($timeFrame instanceof \DateTime) {
			return $this->compareTo($timeFrame) === 0;
		}

		return false;
	}



	/**
	 * @param \DateTime $timeFrame
	 *
	 * @return int
	 */
	public function compareTo(\DateTime $timeFrame)
	{
		if ($this == $timeFrame) {
			return 0;
		}

		return ($this > $timeFrame ? 1 : -1);
	}



	/**
	 * @return bool
	 */
	public function isLeapYear()
	{
		return (bool) $this->format('L');
	}



	/**
	 * @return bool
	 */
	public function isInTheFuture()
	{
		return $this->compareTo(new \DateTime()) === 1;
	}



	/**
	 * @return int
	 */
	public function getYear()
	{
		return $this->format('Y');
	}



	/**
	 * @return int
	 */
	public function getMonth()
	{
		return $this->format('m');
	}



	/**
	 * @return int
	 */
	public function getDay()
	{
		return $this->format('d');
	}



	/**
	 * @return int
	 */
	public function getDayOfYear()
	{
		return $this->format('z');
	}



	/**
	 * @return int
	 */
	public function getDayOfWeek()
	{
		return $this->format('N');
	}



	/**
	 * @return int
	 */
	public function getHour()
	{
		return $this->format('H');
	}



	/**
	 * @return int
	 */
	public function getMinute()
	{
		return $this->format('i');
	}



	/**
	 * @return int
	 */
	public function getSecond()
	{
		return $this->format('s');
	}



	/**
	 * @param string $format
	 * @param string $time
	 * @param DateTimeZone $object
	 * @throws InvalidArgumentException
	 * @return TimeFrame
	 */
	public static function createFromFormat($format, $time, $object = NULL)
	{
		if (!$datetime = \DateTime::createFromFormat($format, $time, $object)) {
			throw new InvalidArgumentException("DateTime cannot be created from time '$time' in format '$format'");
		}

		return self::determinePrecision($datetime);
	}



	/**
	 * DateTime object factory.
	 * @param string|int|\DateTime
	 * @return TimeFrame
	 */
	public static function from($time)
	{
		return new static($time);
	}



	/**
	 * @param \DateTime $timeFrame
	 * @return TimeFrame
	 */
	public static function determinePrecision(\DateTime $timeFrame)
	{
		if ($timeFrame->format('His') > 0) {
			return new Precision\Second($timeFrame);
		}

		return new Precision\Day($timeFrame);
	}



	/*************************** Nette\Object ***************************/



	/**
	 * Access to reflection.
	 * @return \Nette\Reflection\ClassType
	 */
	public static function getReflection()
	{
		return new Nette\Reflection\ClassType(get_called_class());
	}



	/**
	 * Call to undefined method.
	 *
	 * @param string $name
	 * @param array $args
	 *
	 * @throws \Nette\MemberAccessException
	 * @return mixed
	 */
	public function __call($name, $args)
	{
		return Nette\ObjectMixin::call($this, $name, $args);
	}



	/**
	 * Call to undefined static method.
	 *
	 * @param string $name
	 * @param array $args
	 *
	 * @throws \Nette\MemberAccessException
	 * @return mixed
	 */
	public static function __callStatic($name, $args)
	{
		return Nette\ObjectMixin::callStatic(get_called_class(), $name, $args);
	}



	/**
	 * Adding method to class.
	 *
	 * @param $name
	 * @param null $callback
	 *
	 * @throws \Nette\MemberAccessException
	 * @return callable|null
	 */
	public static function extensionMethod($name, $callback = NULL)
	{
		if (strpos($name, '::') === FALSE) {
			$class = get_called_class();
		} else {
			list($class, $name) = explode('::', $name);
		}
		if ($callback === NULL) {
			return Nette\ObjectMixin::getExtensionMethod($class, $name);
		} else {
			Nette\ObjectMixin::setExtensionMethod($class, $name, $callback);
		}
	}



	/**
	 * Returns property value. Do not call directly.
	 *
	 * @param string $name
	 *
	 * @throws \Nette\MemberAccessException
	 * @return mixed
	 */
	public function &__get($name)
	{
		return Nette\ObjectMixin::get($this, $name);
	}



	/**
	 * Sets value of a property. Do not call directly.
	 *
	 * @param string $name
	 * @param mixed $value
	 *
	 * @throws \Nette\MemberAccessException
	 * @return void
	 */
	public function __set($name, $value)
	{
		Nette\ObjectMixin::set($this, $name, $value);
	}



	/**
	 * Is property defined?
	 *
	 * @param string $name
	 *
	 * @return bool
	 */
	public function __isset($name)
	{
		return Nette\ObjectMixin::has($this, $name);
	}



	/**
	 * Access to undeclared property.
	 *
	 * @param string $name
	 *
	 * @throws \Nette\MemberAccessException
	 * @return void
	 */
	public function __unset($name)
	{
		Nette\ObjectMixin::remove($this, $name);
	}

}
