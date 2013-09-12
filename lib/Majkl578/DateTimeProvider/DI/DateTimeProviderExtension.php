<?php

namespace Majkl578\DateTimeProvider\DI;

use Majkl578\DateTimeProvider\NativePhpDateTimeProvider;
use Nette\Config\CompilerExtension;
use Nette\Http\IRequest;

/**
 * @author Michael Moravec
 */
class DateTimeProviderExtension extends CompilerExtension
{
	private $defaults = array(
		'implementation' => 'Majkl578\DateTimeProvider\NativePhpDateTimeProvider', // implementation class name
	);

	public function loadConfiguration()
	{
		$config = $this->getConfig($this->defaults);
		$builder = $this->getContainerBuilder();

		$implementation = $config['implementation'];

		if (!class_exists($implementation)) {
			throw new \UnexpectedValueException("DateTime provider implementation class '$implementation' does not exist or could not be loaded.");
		}

		$rc = new \ReflectionClass($implementation);
		if (!$rc->implementsInterface('Majkl578\DateTimeProvider\IDateTimeProvider')) {
			throw new \UnexpectedValueException("DateTime provider implementation class '$implementation' must implement interface Majkl578\\DateTimeProvider\\IDateTimeProvider.");
		}

		$builder->addDefinition($this->prefix('dateTimeProvider'))
			->setClass($implementation);
	}

	/**
	 * @internal
	 */
	public static function detectProvider(IRequest $httpRequest)
	{
		return new NativePhpDateTimeProvider($httpRequest);
	}
}
