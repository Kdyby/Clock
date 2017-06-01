<?php

/**
 * Test: Kdyby\DateTimeProvider\ConstantProvider.
 *
 * @testCase KdybyTests\DateTimeProvider\ConstantProviderTest
 */

namespace KdybyTests\DateTimeProvider;

use DateTime;
use DateTimeImmutable;
use Kdyby\DateTimeProvider\Providers\ConstantProvider;
use Tester\Assert;
use stdClass;

require_once __DIR__ . '/../bootstrap.php';

class ConstantProviderTest extends \Tester\TestCase
{

	public function testCreateFromNumeric(): void
	{
		$tp = new ConstantProvider(1379123601);
		$datetime = $tp->getDateTime();
		$date = $tp->getDate();
		$time = $tp->getTime();
		$timezone = $tp->getTimezone();

		sleep(2);

		Assert::type(DateTimeImmutable::class, $datetime);
		Assert::same($datetime, $tp->getDateTime());
		Assert::same($date, $tp->getDate());
		Assert::same($time->format('%h:%i:%s'), $tp->getTime()->format('%h:%i:%s'));
		Assert::same($timezone->getName(), $tp->getTimezone()->getName());
	}

	public function testCreateFromMutableDatetime(): void
	{
		$tp = new ConstantProvider(new DateTime('2013-09-14 03:53:21'));
		$datetime = $tp->getDateTime();
		$date = $tp->getDate();
		$time = $tp->getTime();
		$timezone = $tp->getTimezone();

		sleep(2);

		Assert::type(DateTimeImmutable::class, $datetime);
		Assert::same($datetime, $tp->getDateTime());
		Assert::same($date, $tp->getDate());
		Assert::same($time->format('%h:%i:%s'), $tp->getTime()->format('%h:%i:%s'));
		Assert::same($timezone->getName(), $tp->getTimezone()->getName());
	}

	public function testCreateFromMutableDatetimeImmutable(): void
	{
		$tp = new ConstantProvider(new DateTimeImmutable('2013-09-14 03:53:21'));
		$datetime = $tp->getDateTime();
		$date = $tp->getDate();
		$time = $tp->getTime();
		$timezone = $tp->getTimezone();

		sleep(2);

		Assert::type(DateTimeImmutable::class, $datetime);
		Assert::same($datetime, $tp->getDateTime());
		Assert::same($date, $tp->getDate());
		Assert::same($time->format('%h:%i:%s'), $tp->getTime()->format('%h:%i:%s'));
		Assert::same($timezone->getName(), $tp->getTimezone()->getName());
	}

	public function testTimezones(): void
	{
		date_default_timezone_set('Europe/Prague');

		$tp = new ConstantProvider(1379123601);
		Assert::same('Europe/Prague', $tp->getTimezone()->getName());
		Assert::same('2013-09-14 03:53:21 +02:00', $tp->getDateTime()->format('Y-m-d H:i:s P'));

		date_default_timezone_set('Europe/London');

		$tp = new ConstantProvider(1379123601);
		Assert::same('Europe/London', $tp->getTimezone()->getName());
		Assert::same('2013-09-14 02:53:21 +01:00', $tp->getDateTime()->format('Y-m-d H:i:s P'));
	}

	public function testCreateFromUnknownException(): void
	{
		Assert::exception(function () {
			new ConstantProvider('blablabla');
		}, \Kdyby\DateTimeProvider\NotImplementedException::class, 'Cannot process datetime in given format "blablabla"');

		Assert::exception(function () {
			new ConstantProvider(new stdClass());
		}, \Kdyby\DateTimeProvider\NotImplementedException::class, 'Cannot process datetime from given value stdClass');
	}

}

(new ConstantProviderTest())->run();
