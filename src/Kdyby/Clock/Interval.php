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
use Kdyby;
use Nette;



/**
 * @author Filip Procházka <filip@prochazka.su>
 * @author Alexey Shockov <alexey@shockov.com>
 * @author Vyacheslav Salakhutdinov megazoll <megazoll@gmail.com>
 */
class Interval extends \DateInterval
{

	/**
	 * @var \DateInterval
	 */
	private $inner;

	/**
	 * @var array
	 */
	private static $properties = array(
		'y' => TRUE, 'm' => TRUE, 'd' => TRUE, 'h' => TRUE, 'i' => TRUE, 's' => TRUE,
		'weekday' => TRUE, 'weekday_behavior' => TRUE,
		'first_last_day_of' => TRUE, 'invert' => TRUE, 'days' => TRUE,
		'special_type' => TRUE, 'special_amount' => TRUE,
		'have_weekday_relative' => TRUE, 'have_weekday_special' => TRUE
	);



	/**
	 * @param string|\DateInterval $spec
	 */
	public function __construct($spec)
	{
		if ($spec instanceof Interval) {
			$this->inner = clone $spec->inner;

		} elseif ($spec instanceof \DateInterval) {
			$this->inner = clone $spec;

		} else {
			$this->inner = new \DateInterval($spec);
		}

		foreach (self::$properties as $property => $tmp) {
			unset($this->{$property});
		}
	}



	/**
	 * @return int
	 */
	public function toYears()
	{
		return ($this->inner->y * 365 * 24 * 60 * 60);
	}



	/**
	 * @return int
	 */
	public function toMonths()
	{
		return $this->toYears() + ($this->inner->m * 30 * 24 * 60 * 60);
	}



	/**
	 * @return int
	 */
	public function toDays()
	{
		return $this->toMonths() + ($this->inner->d * 24 * 60 * 60);
	}



	/**
	 * @return int
	 */
	public function toHours()
	{
		return $this->toDays() + ($this->inner->h * 60 * 60);
	}



	/**
	 * @return int
	 */
	public function toMinutes()
	{
		return $this->toHours() + ($this->inner->i * 60);
	}



	/**
	 * @return int
	 */
	public function toSeconds()
	{
		return $this->toMinutes() + $this->inner->s;
	}



	/**
	 * @param string $format
	 * @return string
	 */
	public function format($format)
	{
		return $this->inner->format($format);
	}



	/**
	 * @param string $time
	 * @return Interval
	 */
	public static function createFromDateString($time)
	{
		return new static(DateInterval::createFromDateString($time));
	}



	/**
	 * ISO 8601 representation. "P3Y6M4DT12H30M5S", by example.
	 *
	 * @return string
	 */
	public function __toString()
	{
		return self::format2iso($this);
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
		if (isset(self::$properties[$name])) {
			$tmp = $this->inner->{$name};
			return $tmp;
		}

		return Nette\ObjectMixin::get($this, $name);
	}



	/**
	 * @param \DateInterval $di
	 * @return string
	 */
	private static function format2iso(\DateInterval $di)
	{
		return 'P' .
			$di->format('%y') . 'Y' .
			$di->format('%m') . 'M' .
			$di->format('%d') . 'D' .
			'T' .
			$di->format('%h') . 'H' .
			$di->format('%i') . 'M' .
			$di->format('%s') . 'S';
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
	 * @param string $name
	 * @param mixed $value
	 */
	public function __set($name, $value)
	{
		// shhh, it will be all gone in a minute
	}



	/**
	 * @param string $name
	 */
	public function __unset($name)
	{
		// shhh, it will be all gone in a minute
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

}
