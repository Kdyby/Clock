<?php

/**
 * This file is part of the Kdyby (http://www.kdyby.org)
 *
 * Copyright (c) 2008 Filip Procházka (filip@prochazka.su)
 *
 * For the full copyright and license information, please view the file license.txt that was distributed with this source code.
 */

namespace Kdyby\Clock\Providers;

use DateTimeImmutable;

class MutableProvider extends \Kdyby\Clock\Providers\AbstractProvider
{

	public function changePrototype(DateTimeImmutable $prototype)
	{
		$this->prototype = $prototype;
		$this->date = NULL;
	}

}
