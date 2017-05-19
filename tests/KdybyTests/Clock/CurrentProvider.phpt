<?php

/**
 * Test: Kdyby\Clock\CurrentProvider.
 *
 * @testCase KdybyTests\Clock\CurrentProviderTest
 * @author Filip Procházka <filip@prochazka.su>
 * @package Kdyby\Clock
 */

namespace KdybyTests\Clock;

use Kdyby;
use Kdyby\Clock\Providers\CurrentProvider;
use Tester;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';



/**
 * @author Filip Procházka <filip@prochazka.su>
 */
class CurrentProviderTest extends Tester\TestCase
{

	public function testNotConstant()
	{
		$tp = new CurrentProvider();
		$date = $tp->getDate();
		$datetime = $tp->getDateTime();
		$time = $tp->getTime();
		$timezone = $tp->getTimezone();

		sleep(2);

		Assert::type('\DateTimeImmutable', $datetime);
		Assert::same('00:00:00', $date->format('H:i:s'));
		Assert::notEqual($datetime, $tp->getDateTime());
		Assert::notEqual($time->format('%h:%i:%s'), $tp->getTime()->format('%h:%i:%s'));
		Assert::same($timezone->getName(), $tp->getTimezone()->getName());
	}



	public function testTimezones()
	{
		date_default_timezone_set('Europe/Prague');

		$tp = new CurrentProvider();
		Assert::same('Europe/Prague', $tp->getTimezone()->getName());

		date_default_timezone_set('Europe/London');

		$tp = new CurrentProvider();
		Assert::same('Europe/London', $tp->getTimezone()->getName());
	}

}

(new CurrentProviderTest())->run();
