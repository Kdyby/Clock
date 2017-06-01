<?php

/**
 * This file is part of the Kdyby (http://www.kdyby.org)
 *
 * Copyright (c) 2008 Filip Procházka (filip@prochazka.su)
 *
 * For the full copyright and license information, please view the file license.txt that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Kdyby\DateTimeProvider;

interface Exception
{

}

class InvalidStateException extends \RuntimeException implements \Kdyby\DateTimeProvider\Exception
{

}

class InvalidArgumentException extends \InvalidArgumentException implements \Kdyby\DateTimeProvider\Exception
{

}

class UnexpectedValueException extends \UnexpectedValueException implements \Kdyby\DateTimeProvider\Exception
{

}

class NotImplementedException extends \LogicException implements \Kdyby\DateTimeProvider\Exception
{

}
