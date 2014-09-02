<?php

/**
 * Test: Kdyby\Clock\Interval.
 *
 * @testCase KdybyTests\Clock\IntervalTest
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
class IntervalTest extends Tester\TestCase
{

	public function testToString()
	{
		$di = new Kdyby\Clock\Interval('P1Y');
		Assert::same('P1Y0M0DT0H0M0S', (string) $di);
	}



	public function testImmutable()
	{
		$di = new Kdyby\Clock\Interval('P1Y');

		Assert::same(0, $di->s);
		$di->s = 1;
		Assert::same(0, $di->s);

		Assert::same(0, $di->i);
		$di->i = 1;
		Assert::same(0, $di->i);

		Assert::same(0, $di->h);
		$di->h = 1;
		Assert::same(0, $di->h);

		Assert::same(0, $di->d);
		$di->d = 1;
		Assert::same(0, $di->d);

		Assert::same(0, $di->m);
		$di->m = 1;
		Assert::same(0, $di->m);

		Assert::same(1, $di->y);
		$di->y = 2;
		Assert::same(1, $di->y);
	}

}

\run(new IntervalTest());
