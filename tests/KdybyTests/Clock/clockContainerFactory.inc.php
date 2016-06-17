<?php

namespace KdybyTests\Clock;

use Nette;
use Kdyby;


class ClockContainerFactory
{

	public static function createContainer($configFile, $mutable = FALSE)
	{
		$config = new Nette\Configurator();
		$config->setTempDirectory(TEMP_DIR);
		$config->addParameters(array('container' => array('class' => 'SystemContainer_' . md5($configFile))));
		$config->addConfig(__DIR__ . '/../nette-reset.neon');
		if (isset($config->defaultExtensions['nette'])) {
			$config->addConfig(__DIR__ . '/../nette-reset-v22.neon');
		} else {
			$config->addConfig(__DIR__ . '/../nette-reset-v23.neon');
		}
		if ($mutable) {
			$config->addConfig(__DIR__ . '/config/mutable.neon');
		}
		$config->addConfig(__DIR__ . '/config/' . $configFile . '.neon');
		Kdyby\Clock\DI\ClockExtension::register($config);

		return $config->createContainer();
	}

}
