<?php

/**
 * This file is part of the Kdyby (http://www.kdyby.org)
 *
 * Copyright (c) 2008 Filip Procházka (filip@prochazka.su)
 *
 * For the full copyright and license information, please view the file license.txt that was distributed with this source code.
 */

namespace Kdyby\Clock;



/**
 * @author Filip Procházka <filip@prochazka.su>
 */
interface Exception
{

}



/**
 * @author Filip Procházka <filip@prochazka.su>
 */
class InvalidStateException extends \RuntimeException implements Exception
{

}



/**
 * @author Filip Procházka <filip@prochazka.su>
 */
class InvalidArgumentException extends \InvalidArgumentException implements Exception
{

}



/**
 * @author Filip Procházka <filip@prochazka.su>
 */
class UnexpectedValueException extends \UnexpectedValueException implements Exception
{

}



/**
 * @author Filip Procházka <filip@prochazka.su>
 */
class NotEnoughPreciseException extends \RuntimeException implements Exception
{

	/**
	 * @param $currentPrecision
	 * @return NotEnoughPreciseException
	 */
	public static function whenModifying($currentPrecision)
	{
		return new static("The operation you're trying to invoke requires higher precision than this object can achieve, which is $currentPrecision.");
	}

}



/**
 * @author Filip Procházka <filip@prochazka.su>
 */
class NotImplementedException extends \LogicException implements Exception
{

}



/**
 * @author Filip Procházka <filip@prochazka.su>
 */
class ImmutableException extends \LogicException implements Exception
{

	/**
	 * @param object $object
	 * @param string $propertyName
	 * @return ImmutableException
	 */
	public static function fromProperty($object, $propertyName)
	{
		$class = get_class($object);
		return new static("Property $propertyName of $class is immutable and it's state cannot be changed.");
	}



	/**
	 * @param object $object
	 * @param string $methodName
	 * @return ImmutableException
	 */
	public static function fromMethod($object, $methodName)
	{
		$class = get_class($object);
		return new static("Method $methodName of $class cannot be called, because the object is immutable and it's state cannot be changed.");
	}

}
