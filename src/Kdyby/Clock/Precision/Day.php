<?php

/**
 * This file is part of the Kdyby (http://www.kdyby.org)
 *
 * Copyright (c) 2008 Filip Procházka (filip@prochazka.su)
 *
 * For the full copyright and license information, please view the file license.txt that was distributed with this source code.
 */

namespace Kdyby\Clock\Precision;

use DateTimeZone;
use Kdyby;
use Nette;



/**
 * @author Filip Procházka <filip@prochazka.su>
 */
class Day extends Kdyby\Clock\TimeFrame implements Kdyby\Clock\Date
{

	public function __construct($time = 'now', DateTimeZone $timezone = null)
	{
		parent::__construct('Y-m-d', $time, $timezone);
	}

}
