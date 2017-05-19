<?php

/**
 * This file is part of the Kdyby (http://www.kdyby.org)
 *
 * Copyright (c) 2008 Filip Procházka (filip@prochazka.su)
 *
 * For the full copyright and license information, please view the file license.txt that was distributed with this source code.
 */

namespace Kdyby\Clock\DI;

use Kdyby;
use Kdyby\Clock\UnexpectedValueException;
use Nette;
use Nette\PhpGenerator as Code;



/**
 * @author Michael Moravec
 * @author Filip Procházka <filip@prochazka.su>
 */
class ClockExtension extends Nette\DI\CompilerExtension
{

	const STANDARD_PROVIDER = 'standard';
	const REQUEST_PROVIDER = 'request';
	const CURRENT_PROVIDER = 'current';

	public $defaults = [
		'provider' => self::STANDARD_PROVIDER,
	];

	public static $providers = [
		self::STANDARD_PROVIDER => Kdyby\Clock\Providers\ConstantProvider::class,
		self::REQUEST_PROVIDER => Kdyby\Clock\Providers\ConstantProvider::class,
		self::CURRENT_PROVIDER => Kdyby\Clock\Providers\CurrentProvider::class,
	];



	public function loadConfiguration()
	{
		$config = $this->getConfig($this->defaults);
		$builder = $this->getContainerBuilder();

		$providerImpl = $config['provider'];
		if (isset(self::$providers[$providerImpl])) {
			$providerImpl = self::$providers[$providerImpl];
		}

		if (!class_exists($providerImpl)) {
			throw new UnexpectedValueException(sprintf('DateTime provider implementation "%s" does not exist or could not be loaded.', $providerImpl));
		}

		if (!in_array('Kdyby\Clock\IDateTimeProvider', class_implements($providerImpl), TRUE)) {
			throw new UnexpectedValueException(sprintf(
				'DateTime provider implementation "%s" must implement interface %s.',
				$providerImpl,
				Kdyby\Clock\IDateTimeProvider::class
			));
		}

		$providerDef = $builder->addDefinition($this->prefix('dateTimeProvider'))
			->setClass(Kdyby\Clock\IDateTimeProvider::class)
			->setFactory($providerImpl);

		if ($config['provider'] === self::REQUEST_PROVIDER) {
			$providerDef->setArguments([new Code\PhpLiteral('isset($_SERVER["REQUEST_TIME"]) ? $_SERVER["REQUEST_TIME"] : time()')]);
			$providerDef->addTag('run');

		} elseif ($config['provider'] === self::STANDARD_PROVIDER) {
			$providerDef->setArguments([new Code\PhpLiteral('time()')]);
		}
	}



	public static function register(Nette\Configurator $configurator)
	{
		$configurator->onCompile[] = function ($config, Nette\DI\Compiler $compiler) {
			$compiler->addExtension('clock', new ClockExtension());
		};
	}

}
