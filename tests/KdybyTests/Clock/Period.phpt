<?php

/**
 * Test: Kdyby\Clock\Period.
 *
 * @testCase KdybyTests\Clock\PeriodTest
 * @author Filip Procházka <filip@prochazka.su>
 * @package Kdyby\Clock
 */

namespace KdybyTests\Clock;

use Kdyby;
use Nette;
use Tester;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';



/**
 * @author Filip Procházka <filip@prochazka.su>
 * @author Alexey Shockov <alexey@shockov.com>
 */
class PeriodTest extends Tester\TestCase
{

	public function testIteration()
	{
		$dp = new Kdyby\Clock\Period('R5/2008-03-01T13:00:00Z/P1Y2M10DT2H30M');

		$dates = array();

		foreach ($dp as $dt)
			$dates[] = $dt;

		Assert::equal(array(
			new \DateTime('2008-03-01T13:00:00+00:00'),
			new \DateTime('2009-05-11T15:30:00+00:00'),
			new \DateTime('2010-07-21T18:00:00+00:00'),
			new \DateTime('2011-10-01T20:30:00+00:00'),
			new \DateTime('2012-12-11T23:00:00+00:00'),
			new \DateTime('2014-02-22T01:30:00+00:00'),
		), $dates);
	}



	public function testToString()
	{
		$dp = new Kdyby\Clock\Period('R5/2008-03-01T13:00:00Z/P1Y2M10DT2H30M');
		Assert::same('2008-03-01T13:00:00Z/P1Y2M10DT2H30M0S/2014-02-22T01:30:00Z', (string) $dp);
	}

}

\run(new PeriodTest());
