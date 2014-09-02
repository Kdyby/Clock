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
interface Date
{

	/**
	 * @return int
	 */
	function getYear();



	/**
	 * @return int
	 */
	function getMonth();



	/**
	 * @return int
	 */
	function getDay();



	/**
	 * @return int
	 */
	function getDayOfYear();



	/**
	 * @return int
	 */
	function getDayOfWeek();

}
