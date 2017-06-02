<?php

/**
 * Test: Kdyby\DateTimeProvider\ConstantProvider.
 *
 * @testCase KdybyTests\DateTimeProvider\ConstantProviderTest
 */

declare(strict_types = 1);

namespace KdybyTests\DateTimeProvider;

use DateTimeImmutable;
use Kdyby\DateTimeProvider\Provider\ConstantProvider;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

class ConstantProviderTest extends \Tester\TestCase
{

	public function testConstant(): void
	{
		$tp = new ConstantProvider(new DateTimeImmutable('2013-09-14 03:53:21.123456'));
		$datetime = $tp->getDateTime();
		$date = $tp->getDate();
		$time = $tp->getTime();
		$timezone = $tp->getTimeZone();

		sleep(2);

		Assert::same($datetime, $tp->getDateTime());
		Assert::same($date->getTimestamp(), $tp->getDate()->getTimestamp());
		Assert::same($time->format('%h:%i:%s.%f'), $tp->getTime()->format('%h:%i:%s.%f'));
		Assert::same($timezone->getName(), $tp->getTimeZone()->getName());
	}

}

(new ConstantProviderTest())->run();
