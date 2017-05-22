<?php

/**
 * This file is part of the Kdyby (http://www.kdyby.org)
 *
 * Copyright (c) 2008 Filip Procházka (filip@prochazka.su)
 *
 * For the full copyright and license information, please view the file license.txt that was distributed with this source code.
 */

namespace Kdyby\Clock;

interface Exception
{

}

class InvalidStateException extends \RuntimeException implements \Kdyby\Clock\Exception
{

}

class InvalidArgumentException extends \InvalidArgumentException implements \Kdyby\Clock\Exception
{

}

class UnexpectedValueException extends \UnexpectedValueException implements \Kdyby\Clock\Exception
{

}

class NotImplementedException extends \LogicException implements \Kdyby\Clock\Exception
{

}
