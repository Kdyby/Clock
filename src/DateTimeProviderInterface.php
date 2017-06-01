<?php

/**
 * This file is part of the Kdyby (http://www.kdyby.org)
 *
 * Copyright (c) 2008 Filip Procházka (filip@prochazka.su)
 *
 * For the full copyright and license information, please view the file license.txt that was distributed with this source code.
 */

namespace Kdyby\DateTimeProvider;

use DateInterval;
use DateTimeImmutable;
use DateTimeZone;

interface DateTimeProviderInterface
{

	public function getDate(): DateTimeImmutable;

	public function getTime(): DateInterval;

	public function getDateTime(): DateTimeImmutable;

	public function getTimezone(): DateTimeZone;

}
