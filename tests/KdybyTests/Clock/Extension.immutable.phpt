<?php

/**
 * Test: Kdyby\Clock\Extension.
 *
 * @testCase Kdyby\Clock\ExtensionTest
 * @author Filip Procházka <filip@prochazka.su>
 * @package Kdyby\Clock
 */

namespace KdybyTests\Clock;

use Kdyby;
use Nette;
use Tester;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';
require_once __DIR__ . '/clockContainerFactory.inc.php';


if (PHP_VERSION_ID <= 50500) {
	Tester\Environment::skip('DateTimeImmutable is not available on PHP < 5.5');
}

/**
 * @author Filip Procházka <filip@prochazka.su>
 */
class ExtensionImmutableTest extends Tester\TestCase
{

	/**
	 * @param string $configFile
	 * @return \SystemContainer|Nette\DI\Container
	 */
	public function createContainer($configFile)
	{
		return ClockContainerFactory::createContainer($configFile);
	}



	public function testStandardProvider()
	{
		$container = $this->createContainer('provider.standard');
		$provider = $container->getByType('Kdyby\Clock\IDateTimeProvider');
		/** @var \Kdyby\Clock\IDateTimeProvider $provider */

		Assert::true($provider instanceof Kdyby\Clock\ImmutableProviders\ConstantProvider);
	}



	public function testRequestTimeProvider()
	{
		$container = $this->createContainer('provider.requestTime');
		$provider = $container->getByType('Kdyby\Clock\IDateTimeProvider');
		/** @var \Kdyby\Clock\IDateTimeProvider $provider */

		Assert::true($provider instanceof Kdyby\Clock\ImmutableProviders\ConstantProvider);
		Assert::same((string) $_SERVER['REQUEST_TIME'], $provider->getDateTime()->format('U'));

		$_SERVER['REQUEST_TIME'] = 987654321;

		Assert::notSame((string) $_SERVER['REQUEST_TIME'], $provider->getDateTime()->format('U'));
	}



	public function testCurrentProvider()
	{
		$container = $this->createContainer('provider.current');
		$provider = $container->getByType('Kdyby\Clock\IDateTimeProvider');
		/** @var \Kdyby\Clock\IDateTimeProvider $provider */

		Assert::true($provider instanceof Kdyby\Clock\ImmutableProviders\CurrentProvider);
	}

}

\run(new ExtensionImmutableTest());
