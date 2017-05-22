<?php

/**
 * This file is part of the Kdyby (http://www.kdyby.org)
 *
 * Copyright (c) 2008 Filip Procházka (filip@prochazka.su)
 *
 * For the full copyright and license information, please view the file license.txt that was distributed with this source code.
 */

namespace Kdyby\Clock\DI;

use Kdyby\Clock\IDateTimeProvider;
use Kdyby\Clock\Providers\ConstantProvider;
use Kdyby\Clock\Providers\CurrentProvider;
use Nette\Configurator;
use Nette\DI\Compiler;
use Nette\PhpGenerator\PhpLiteral;

class ClockExtension extends \Nette\DI\CompilerExtension
{

	const STANDARD_PROVIDER = 'standard';
	const REQUEST_PROVIDER = 'request';
	const CURRENT_PROVIDER = 'current';

	/**
	 * @var string[]
	 */
	public $defaults = [
		'provider' => self::STANDARD_PROVIDER,
	];

	/**
	 * @var string[]
	 */
	public static $providers = [
		self::STANDARD_PROVIDER => ConstantProvider::class,
		self::REQUEST_PROVIDER => ConstantProvider::class,
		self::CURRENT_PROVIDER => CurrentProvider::class,
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
			throw new \Kdyby\Clock\UnexpectedValueException(sprintf('DateTime provider implementation "%s" does not exist or could not be loaded.', $providerImpl));
		}

		if (!in_array(IDateTimeProvider::class, class_implements($providerImpl), TRUE)) {
			throw new \Kdyby\Clock\UnexpectedValueException(sprintf(
				'DateTime provider implementation "%s" must implement interface %s.',
				$providerImpl,
				IDateTimeProvider::class
			));
		}

		$providerDef = $builder->addDefinition($this->prefix('dateTimeProvider'))
			->setClass(IDateTimeProvider::class)
			->setFactory($providerImpl);

		if ($config['provider'] === self::REQUEST_PROVIDER) {
			$providerDef->setArguments([new PhpLiteral('isset($_SERVER["REQUEST_TIME"]) ? $_SERVER["REQUEST_TIME"] : time()')]);
			$providerDef->addTag('run');

		} elseif ($config['provider'] === self::STANDARD_PROVIDER) {
			$providerDef->setArguments([new PhpLiteral('time()')]);
		}
	}

	public static function register(Configurator $configurator)
	{
		$configurator->onCompile[] = function ($config, Compiler $compiler) {
			$compiler->addExtension('clock', new ClockExtension());
		};
	}

}
