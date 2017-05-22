<?php

/**
 * Test: Kdyby\Clock\MutableProvider.
 *
 * @testCase
 */

namespace KdybyTests\Clock;

use DateTimeImmutable;
use Kdyby\Clock\Providers\MutableProvider;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

class MutableProviderTest extends \Tester\TestCase
{

	public function testConstant()
	{
		$tp = new MutableProvider(new DateTimeImmutable('2013-09-14 03:53:21'));
		$datetime = $tp->getDateTime();
		$date = $tp->getDate();
		$time = $tp->getTime();
		$timezone = $tp->getTimezone();

		sleep(2);

		Assert::same($datetime, $tp->getDateTime());
		Assert::same($date, $tp->getDate());
		Assert::same($time->format('%h:%i:%s'), $tp->getTime()->format('%h:%i:%s'));
		Assert::same($timezone->getName(), $tp->getTimezone()->getName());
	}

	public function testTimezones()
	{
		date_default_timezone_set('Europe/Prague');

		$tp = new MutableProvider(new DateTimeImmutable(date('Y-m-d H:i:s', 1379123601)));
		Assert::same('Europe/Prague', $tp->getTimezone()->getName());
		Assert::same('2013-09-14 03:53:21 +02:00', $tp->getDateTime()->format('Y-m-d H:i:s P'));

		date_default_timezone_set('Europe/London');

		$tp = new MutableProvider(new DateTimeImmutable(date('Y-m-d H:i:s', 1379123601)));
		Assert::same('Europe/London', $tp->getTimezone()->getName());
		Assert::same('2013-09-14 02:53:21 +01:00', $tp->getDateTime()->format('Y-m-d H:i:s P'));
	}

	public function testChangePrototype()
	{
		$tp = new MutableProvider($originalTime = new DateTimeImmutable('2013-09-14 03:53:21'));
		Assert::same($originalTime, $tp->getDateTime());

		$tp->changePrototype($changedTime = new DateTimeImmutable('2015-01-09 18:34:00'));
		Assert::notEqual($originalTime, $tp->getDateTime());
		Assert::same($changedTime, $tp->getDateTime());
	}

}

(new MutableProviderTest())->run();
