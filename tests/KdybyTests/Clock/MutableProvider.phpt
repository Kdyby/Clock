<?php

/**
 * Test: Kdyby\Clock\MutableProvider.
 *
 * @testCase KdybyTests\Clock\MutableProviderTest
 * @author Filip Procházka <filip@prochazka.su>
 * @package Kdyby\Clock
 */

namespace KdybyTests\Clock;

use Kdyby;
use Kdyby\Clock\Providers\MutableProvider;
use Nette;
use Tester;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';



/**
 * @author Filip Procházka <filip@prochazka.su>
 */
class MutableProviderTest extends Tester\TestCase
{

	public function testConstant()
	{
		$tp = new MutableProvider(new \DateTime('2013-09-14 03:53:21'));
		$datetime = $tp->getDateTime();
		$date = $tp->getDate();
		$time = $tp->getTime();
		$timezone = $tp->getTimezone();

		sleep(2);

		Assert::equal($datetime, $tp->getDateTime());
		Assert::equal($date, $tp->getDate());
		Assert::equal($time, $tp->getTime());
		Assert::equal($timezone, $tp->getTimezone());
	}



	public function testImmutableGetters()
	{
		$tp = new MutableProvider(new \DateTime('2013-09-14 03:53:21'));

		$datetime = $tp->getDateTime();
		$tp->getDateTime()->modify('+1 hour');
		Assert::equal($datetime, $tp->getDateTime());
	}



	public function testImmutableThroughConstructor()
	{
		$tp = new MutableProvider($originalTime = new \DateTime('2013-09-14 03:53:21'));
		Assert::equal($originalTime, $tp->getDateTime());

		$originalTime->modify('+1 hour');
		Assert::notEqual($originalTime, $tp->getDateTime());
	}



	public function testTimezones()
	{
		date_default_timezone_set('Europe/Prague');

		$tp = new MutableProvider(new \DateTime(date('Y-m-d H:i:s', 1379123601)));
		Assert::same('Europe/Prague', $tp->getTimezone()->getName());
		Assert::same('2013-09-14 03:53:21 +02:00', $tp->getDateTime()->format('Y-m-d H:i:s P'));

		date_default_timezone_set('Europe/London');

		$tp = new MutableProvider(new \DateTime(date('Y-m-d H:i:s', 1379123601)));
		Assert::same('Europe/London', $tp->getTimezone()->getName());
		Assert::same('2013-09-14 02:53:21 +01:00', $tp->getDateTime()->format('Y-m-d H:i:s P'));
	}



	public function testChangePrototype()
	{
		$tp = new MutableProvider($originalTime = new \DateTime('2013-09-14 03:53:21'));
		Assert::equal($originalTime, $tp->getDateTime());

		$tp->changePrototype($changedTime = new \DateTime('2015-01-09 18:34:00'));
		Assert::notEqual($originalTime, $tp->getDateTime());
		Assert::equal($changedTime, $tp->getDateTime());
	}

}

\run(new MutableProviderTest());
