<?php
/**
 * Copyright ©  2020. Mantik Tech.  All rights reserved under CC BY-NC-SA 4.0 licence.
 * See LICENSE file for more details.
 * @link https://www.mantik.tech/
 */

namespace Mantik\Bluemail\Logger\Handler;

use Magento\Framework\Logger\Handler\Base;
use Monolog\Logger;

class System extends Base
{
    protected $loggerType = Logger::DEBUG;

    protected $fileName = '/var/log/bluemail.log';
}
