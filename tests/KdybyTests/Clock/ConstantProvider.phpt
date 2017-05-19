<?php

/**
 * Test: Kdyby\Clock\ConstantProvider.
 *
 * @testCase KdybyTests\Clock\ConstantProviderTest
 * @author Filip Procházka <filip@prochazka.su>
 * @package Kdyby\Clock
 */

namespace KdybyTests\Clock;

use Kdyby;
use Kdyby\Clock\Providers\ConstantProvider;
use Tester;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';



/**
 * @author Filip Procházka <filip@prochazka.su>
 */
class ConstantProviderTest extends Tester\TestCase
{

	public function testConstant()
	{
		$tp = new ConstantProvider(1379123601);
		$datetime = $tp->getDateTime();
		$date = $tp->getDate();
		$time = $tp->getTime();
		$timezone = $tp->getTimezone();

		sleep(2);

		Assert::type('\DateTimeImmutable', $datetime);
		Assert::same($datetime, $tp->getDateTime());
		Assert::same($date, $tp->getDate());
		Assert::same($time->format('%h:%i:%s'), $tp->getTime()->format('%h:%i:%s'));
		Assert::same($timezone->getName(), $tp->getTimezone()->getName());
	}



	public function testTimezones()
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

}

(new ConstantProviderTest())->run();
