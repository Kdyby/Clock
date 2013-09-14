<?php

/**
 * Test: Kdyby\Clock\RequestTimeProvider.
 *
 * @testCase KdybyTests\Clock\RequestTimeProviderTest
 * @author Filip Procházka <filip@prochazka.su>
 * @package Kdyby\Clock
 */

namespace KdybyTests\Clock;

use Kdyby;
use Kdyby\Clock\Providers\RequestTimeProvider;
use Nette;
use Tester;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';



/**
 * @author Filip Procházka <filip@prochazka.su>
 */
class RequestTimeProviderTest extends Tester\TestCase
{

	public function testTimezones()
	{
		date_default_timezone_set('Europe/Prague');

		$rtp = new RequestTimeProvider(1379123601);
		Assert::same('Europe/Prague', $rtp->getTimezone()->getName());
		Assert::same('2013-09-14 03:53:21 +02:00', $rtp->getDateTime()->format('Y-m-d H:i:s P'));

		date_default_timezone_set('Europe/London');

		$rtp = new RequestTimeProvider(1379123601);
		Assert::same('Europe/London', $rtp->getTimezone()->getName());
		Assert::same('2013-09-14 02:53:21 +01:00', $rtp->getDateTime()->format('Y-m-d H:i:s P'));
	}

}

\run(new RequestTimeProviderTest());
