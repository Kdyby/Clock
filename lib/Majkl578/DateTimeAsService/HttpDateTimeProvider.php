<?php

namespace Majkl578\DateTimeAsService;

use Nette\Http\IRequest;
use Nette\Utils\Strings;

/**
 * @author Michael Moravec
 */
class HttpDateTimeProvider extends AbstractDateTimeProvider
{
	public function __construct(IRequest $httpRequest)
	{
		$requestTime = $httpRequest->getHeader('Request-Time');

		if (!$requestTime) { // TODO: or fallback to time()?
			throw new \InvalidArgumentException('Http request does not contain Request-Time header.');
		}

		if (!Strings::match($requestTime, '~^\d{1,10}\z~')) {
			throw new \InvalidArgumentException('Http request provided invalid time header.');
		}

		$this->dateTimePrototype = new \DateTime("@$requestTime");
	}
}
