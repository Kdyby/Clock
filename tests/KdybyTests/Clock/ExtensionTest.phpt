<?php

/**
 * Test: Kdyby\Clock\Extension.
 *
 * @testCase
 */

namespace KdybyTests\Clock;

use Kdyby\Clock\DI\ClockExtension;
use Kdyby\Clock\IDateTimeProvider;
use Kdyby\Clock\Providers\ConstantProvider;
use Kdyby\Clock\Providers\CurrentProvider;
use Nette\Configurator;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

class ExtensionTest extends \Tester\TestCase
{

	/**
	 * @param string $configFile
	 * @return \SystemContainer|\Nette\DI\Container
	 */
	public function createContainer($configFile)
	{
		$config = new Configurator();
		$config->setTempDirectory(TEMP_DIR);
		$config->addParameters(['container' => ['class' => 'SystemContainer_' . md5($configFile)]]);
		$config->addConfig(__DIR__ . '/config/' . $configFile . '.neon');
		ClockExtension::register($config);

		return $config->createContainer();
	}

	public function testStandardProvider()
	{
		$container = $this->createContainer('provider.standard');
		/** @var \Kdyby\Clock\IDateTimeProvider $provider */
		$provider = $container->getByType(IDateTimeProvider::class);

		Assert::true($provider instanceof ConstantProvider);
	}

	public function testRequestTimeProvider()
	{
		$container = $this->createContainer('provider.requestTime');
		/** @var \Kdyby\Clock\IDateTimeProvider $provider */
		$provider = $container->getByType(IDateTimeProvider::class);

		Assert::true($provider instanceof ConstantProvider);
		Assert::same((string) $_SERVER['REQUEST_TIME'], $provider->getDateTime()->format('U'));

		$_SERVER['REQUEST_TIME'] = 987654321;

		Assert::notSame((string) $_SERVER['REQUEST_TIME'], $provider->getDateTime()->format('U'));
	}

	public function testCurrentProvider()
	{
		$container = $this->createContainer('provider.current');
		/** @var \Kdyby\Clock\IDateTimeProvider $provider */
		$provider = $container->getByType(IDateTimeProvider::class);

		Assert::true($provider instanceof CurrentProvider);
	}

}

(new ExtensionTest())->run();
