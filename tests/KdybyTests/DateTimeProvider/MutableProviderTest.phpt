<?php

/**
 * Test: Kdyby\DateTimeProvider\MutableProvider.
 *
 * @testCase
 */

declare(strict_types = 1);

namespace KdybyTests\DateTimeProvider;

use DateTimeImmutable;
use Kdyby\DateTimeProvider\Provider\MutableProvider;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

class MutableProviderTest extends \Tester\TestCase
{

	public function testConstant(): void
	{
		$tp = new MutableProvider(new DateTimeImmutable('2013-09-14 03:53:21'));
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

	public function testTimezones(): void
	{
		date_default_timezone_set('Europe/Prague');

		$tp = new MutableProvider(new DateTimeImmutable(date('Y-m-d H:i:s', 1379123601)));
		Assert::same('Europe/Prague', $tp->getTimeZone()->getName());
		Assert::same('2013-09-14 03:53:21 +02:00', $tp->getDateTime()->format('Y-m-d H:i:s P'));

		date_default_timezone_set('Europe/London');

		$tp = new MutableProvider(new DateTimeImmutable(date('Y-m-d H:i:s', 1379123601)));
		Assert::same('Europe/London', $tp->getTimeZone()->getName());
		Assert::same('2013-09-14 02:53:21 +01:00', $tp->getDateTime()->format('Y-m-d H:i:s P'));
	}

	public function testChangePrototype(): void
	{
		$tp = new MutableProvider($originalTime = new DateTimeImmutable('2013-09-14 03:53:21'));
		Assert::same($originalTime, $tp->getDateTime());

		$tp->changePrototype($changedTime = new DateTimeImmutable('2015-01-09 18:34:00'));
		Assert::notEqual($originalTime, $tp->getDateTime());
		Assert::same($changedTime, $tp->getDateTime());
	}

	public function testMicroseconds(): void
	{
		$tp = new MutableProvider(new DateTimeImmutable('2013-09-14 03:53:21.123456'));
		$datetime = $tp->getDateTime();
		$date = $tp->getDate();
		$time = $tp->getTime();
		$timezone = $tp->getTimeZone();

		usleep(100);

		Assert::same($datetime, $tp->getDateTime());
		Assert::same($date->getTimestamp(), $tp->getDate()->getTimestamp());
		Assert::same($time->format('%h:%i:%s.%f'), $tp->getTime()->format('%h:%i:%s.%f'));
		Assert::same($timezone->getName(), $tp->getTimeZone()->getName());
	}

}

(new MutableProviderTest())->run();
