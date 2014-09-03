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
class ConstantProvider extends AbstractProvider
{

	/**
	 * @param string|int|\DateTime $dateTime
	 */
	public function __construct($dateTime)
	{
		if ($dateTime instanceof \DateTime) {
			parent::__construct(clone $dateTime);

		} elseif (is_numeric($dateTime)) {
			parent::__construct(new \DateTime(date('Y-m-d H:i:s', $dateTime), new \DateTimeZone(date_default_timezone_get())));

		} else {
			throw new Kdyby\Clock\NotImplementedException(sprintf('Cannot process datetime in given format %s', $dateTime));
		}
	}

}
