<?php

/**
 * Test: Kdyby\Clock\DateTime.
 *
 * @testCase KdybyTests\Clock\DateTimeTest
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
 */
class DateTimeTest extends Tester\TestCase
{

	public function testModify()
	{

	}

}

$rf = new \ReflectionClass('Datetime');
$lit = Nette\PhpGenerator\Method::from($rf->getMethod('createFromFormat'));
echo $lit;

\run(new DateTimeTest());
