<?php

/**
 * This file is part of the Kdyby (http://www.kdyby.org)
 *
 * Copyright (c) 2008 Filip Procházka (filip@prochazka.su)
 *
 * For the full copyright and license information, please view the file license.txt that was distributed with this source code.
 */

namespace Kdyby\Clock\ImmutableProviders;

use Kdyby;
use Nette;



/**
 * @author Filip Procházka <filip@prochazka.su>
 * @author Richard Ejem <richard@ejem.cz>
 */
class ConstantProvider extends AbstractProvider
{

	/**
	 * @param string|int|\DateTimeInterface $dateTime
	 */
	public function __construct($dateTime)
	{
		if ($dateTime instanceof \DateTimeInterface) {
			if ($dateTime instanceof \DateTime) {
				$dateTime = \DateTimeImmutable::createFromMutable($dateTime);
			}
			parent::__construct($dateTime);

		} elseif (is_numeric($dateTime)) {
			parent::__construct(new \DateTimeImmutable(date('Y-m-d H:i:s', $dateTime), new \DateTimeZone(date_default_timezone_get())));

		} else {
			throw new Kdyby\Clock\NotImplementedException(sprintf('Cannot process datetime in given format %s', $dateTime));
		}
	}

}
