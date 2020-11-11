<?php
/**
 * Copyright ©  2020. Mantik Tech.  All rights reserved under CC BY-NC-SA 4.0 licence.
 * See LICENSE file for more details.
 * @link https://www.mantik.tech/
 */

namespace Mantik\Bluemail\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Mantik\Bluemail\Helper\Config as ConfigHelper;
use Mantik\Bluemail\Logger\Logger;

class Debug extends AbstractHelper
{
    /**
     * @var Logger
     */
    protected $logger;

    /**
     * @var Config
     */
    private $configHelper;

    /**
     * Debug constructor.
     * @param Context $context
     * @param ConfigHelper $configHelper
     * @param Logger $logger
     */
    public function __construct(
        Context $context,
        ConfigHelper $configHelper,
        Logger $logger
    ) {
        $this->configHelper = $configHelper;
        $this->logger = $logger;
        parent::__construct($context);
    }

    /**
     * Log custom message using Bluemail logger instance
     *
     * @param mixed $message
     * @param mixed $name
     */
    public function log($message, $name="bluemail")
    {
        if (!$this->configHelper->getDebuggerState()) {
            return;
        }
        $this->logger->setName($name);
        $this->logger->debug(json_encode($message));
    }
}
