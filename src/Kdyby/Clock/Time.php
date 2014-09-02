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



/**
 * @author Filip Procházka <filip@prochazka.su>
 */
interface Time
{

	/**
	 * @return int
	 */
	function getHour();



	/**
	 * @return int
	 */
	function getMinute();



	/**
	 * @return int
	 */
	function getSecond();

}
