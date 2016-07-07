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



/**
 * @author Filip Procházka <filip@prochazka.su>
 */
class ExtensionTest extends Tester\TestCase
{

	/**
	 * @param string $configFile
	 * @return \SystemContainer|Nette\DI\Container
	 */
	public function createContainer($configFile)
	{
		$config = new Nette\Configurator();
		$config->setTempDirectory(TEMP_DIR);
		$config->addParameters(['container' => ['class' => 'SystemContainer_' . md5($configFile)]]);
		$config->addConfig(__DIR__ . '/../nette-reset.' . (!isset($config->defaultExtensions['nette']) ? 'v23' : 'v22') . '.neon');
		$config->addConfig(__DIR__ . '/config/' . $configFile . '.neon');
		Kdyby\Clock\DI\ClockExtension::register($config);

		return $config->createContainer();
	}



	public function testStandardProvider()
	{
		$container = $this->createContainer('provider.standard');
		$provider = $container->getByType('Kdyby\Clock\IDateTimeProvider');
		/** @var \Kdyby\Clock\IDateTimeProvider $provider */

		Assert::true($provider instanceof Kdyby\Clock\Providers\ConstantProvider);
	}



	public function testRequestTimeProvider()
	{
		$container = $this->createContainer('provider.requestTime');
		$provider = $container->getByType('Kdyby\Clock\IDateTimeProvider');
		/** @var \Kdyby\Clock\IDateTimeProvider $provider */

		Assert::true($provider instanceof Kdyby\Clock\Providers\ConstantProvider);
		Assert::same((string) $_SERVER['REQUEST_TIME'], $provider->getDateTime()->format('U'));

		$_SERVER['REQUEST_TIME'] = 987654321;

		Assert::notSame((string) $_SERVER['REQUEST_TIME'], $provider->getDateTime()->format('U'));
	}



	public function testCurrentProvider()
	{
		$container = $this->createContainer('provider.current');
		$provider = $container->getByType('Kdyby\Clock\IDateTimeProvider');
		/** @var \Kdyby\Clock\IDateTimeProvider $provider */

		Assert::true($provider instanceof Kdyby\Clock\Providers\CurrentProvider);
	}

}

\run(new ExtensionTest());
