<?php

/**
 * This file is part of the Kdyby (http://www.kdyby.org)
 *
 * Copyright (c) 2008 Filip Procházka (filip@prochazka.su)
 *
 * For the full copyright and license information, please view the file license.txt that was distributed with this source code.
 */

namespace Kdyby\Clock\Providers;

use Kdyby;
use Nette;



/**
 * @author Filip Procházka <filip@prochazka.su>
 */
class RequestTimeProvider extends AbstractProvider
{

	/**
	 * @param string|int|\DateTime $httpRequestTime
	 */
	public function __construct($httpRequestTime)
	{
		if ($httpRequestTime instanceof \DateTime) {
			parent::__construct($httpRequestTime);

		} else {
			parent::__construct(new \DateTime(date('Y-m-d H:i:s', $httpRequestTime), new \DateTimeZone(date_default_timezone_get())));
		}
	}

}
