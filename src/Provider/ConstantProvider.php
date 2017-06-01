<?php

/**
 * This file is part of the Kdyby (http://www.kdyby.org)
 *
 * Copyright (c) 2008 Filip Procházka (filip@prochazka.su)
 *
 * For the full copyright and license information, please view the file license.txt that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Kdyby\DateTimeProvider\Provider;

use DateTimeImmutable;

class ConstantProvider implements \Kdyby\DateTimeProvider\DateTimeProviderInterface
{

	use \Kdyby\DateTimeProvider\Provider\ImmutableProviderTrait;
	use \Kdyby\StrictObjects\Scream;

	/**
	 * @var \DateTimeImmutable
	 */
	private $prototype;

	public function __construct(DateTimeImmutable $dateTime)
	{
		$this->prototype = $dateTime;
	}

	protected function getPrototype(): DateTimeImmutable
	{
		return $this->prototype;
	}

}
