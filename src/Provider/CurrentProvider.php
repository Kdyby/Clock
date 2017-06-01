<?php

/**
 * This file is part of the Kdyby (http://www.kdyby.org)
 *
 * Copyright (c) 2008 Filip Procházka (filip@prochazka.su)
 *
 * For the full copyright and license information, please view the file license.txt that was distributed with this source code.
 */

namespace Kdyby\DateTimeProvider\Provider;

use DateTimeImmutable;

class CurrentProvider implements \Kdyby\DateTimeProvider\DateTimeProviderInterface
{

	use \Kdyby\DateTimeProvider\Provider\ProviderTrait;
	use \Kdyby\StrictObjects\Scream;

	/**
	 * {@inheritdoc}
	 */
	public function getPrototype(): DateTimeImmutable
	{
		return new DateTimeImmutable();
	}

}
