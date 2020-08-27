<?php
/**
 * Copyright ©  2020. Mantik Tech.  All rights reserved under CC BY-NC-SA 4.0 licence.
 * See LICENSE file for more details.
 * @link https://www.mantik.tech/
 */

declare(strict_types=1);

namespace Mantik\Bluemail\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;

class Config extends AbstractHelper
{
    /**
     * Common Constants
     */
    const SECTION = 'carriers/';
    const GROUP = 'bluemail/';

    /**
     * Databse paths
     */
    const CONFIG_MODULE_ENABLED = self::SECTION . self::GROUP . 'active';
    const CONFIG_METHOD_NAME = self::SECTION . self::GROUP . 'name';
    const CONFIG_XAPP_TOKEN = self::SECTION . self::GROUP . 'token';
    const CONFIG_CUSTOMER_ID = self::SECTION . self::GROUP . 'customerid';
    const CONFIG_COUNTRY_RESTRICTION = self::SECTION . self::GROUP . 'sallowspecific';

    /**
     * API Access Url
     */
    const BLUEMAIL_API_URL = 'https://api-test.bluemailbox.com.ar/v1/';

    /**
     * @param Context $context
     */
    public function __construct(
        Context $context
    ) {
        parent::__construct($context);
    }

    /**
     * Return Enabled Status
     *
     * @return mixed
     */
    public function isEnabled() {
        return $this->getConfigValue(self::CONFIG_MODULE_ENABLED);
    }

    /**
     * Return Method Name
     *
     * @return mixed
     */
    public function getMethodName() {
        return $this->getConfigValue(self::CONFIG_METHOD_NAME);
    }

    /**
     * Get Bluemail X-Midla-App-Token
     *
     * @return mixed
     */
    public function getAppToken() {
        return $this->getConfigValue(self::CONFIG_XAPP_TOKEN);
    }

    /**
     * Get Bluemail Client ID
     *
     * @return mixed
     */
    public function getCustomerId() {
        return $this->getConfigValue(self::CONFIG_CUSTOMER_ID);
    }

    /**
     * Get Country Restrictions
     *
     * @return mixed
     */
    public function getCountryRestrictions() {
        return $this->getConfigValue(self::CONFIG_COUNTRY_RESTRICTION);
    }

    public function getApiUrl() {
        return self::BLUEMAIL_API_URL;
    }

    /**
     * Return specific config value based on path
     *
     * @param $path
     * @param null $storeCode
     * @return mixed
     */
    private function getConfigValue (
        $path,
        $storeCode = null
    ) {
        return $this->scopeConfig->getValue(
            $path,
            ScopeInterface::SCOPE_STORE,
            $storeCode
        );
    }
}
