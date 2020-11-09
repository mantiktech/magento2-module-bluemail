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
    protected $_logger;
    /**
     * @var Config
     */
    private $_configHelper;

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
    )
    {
        parent::__construct($context);
        $this->_configHelper = $configHelper;
        $this->_logger = $logger;
    }

    /**
     * Log custom message using Bluemail logger instance
     *
     * @param array $message
     * @param string $name
     */
    public function log(array $message, string $name = "bluemail")
    {
        if (!$this->_configHelper->getDebuggerState()) {
            return;
        }
        $this->_logger->setName($name);
        $this->_logger->debug(json_encode($message));
    }
}
