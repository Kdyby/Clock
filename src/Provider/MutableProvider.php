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

class MutableProvider extends \Kdyby\DateTimeProvider\Provider\AbstractProvider
{

	public function changePrototype(DateTimeImmutable $prototype): void
	{
		$this->prototype = $prototype;
		$this->date = NULL;
	}

}
