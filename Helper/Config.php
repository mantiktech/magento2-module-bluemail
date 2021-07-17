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

/**
 * Class Config
 */
class Config extends AbstractHelper
{
    /**
     * Common Constants
     */
    const BLUEMAIL_CODE = 'bluemail';
    const BLUEMAIL_URL = 'https://envios.bluemail.com.ar/';
    const BLUEMAIL_URL_SANDBOX = 'http://envios.bluemail.com.ar/';
    const SECTION = 'carriers/';
    const GROUP = 'bluemail/';
    const DEFAULT_COUNTRY = '23';
    const API_REQUEST_ORIGEN_ID = '6';
    const API_REQUEST_FROM_TYPE = 'CLIENT';

    /**
     * Databse paths
     */
    const CONFIG_MODULE_ENABLED = self::SECTION . self::GROUP . 'active';
    const CONFIG_SANDBOX_ENABLED = self::SECTION . self::GROUP . 'sandboxmode';
    const CONFIG_DEBUGGER_ENABLED = self::SECTION . self::GROUP . 'debugger';

    const CONFIG_METHOD_NAME = self::SECTION . self::GROUP . 'name';

    const CONFIG_SANDBOX_API_URL = self::SECTION . self::GROUP . 'sandboxapiurl';
    const CONFIG_SANDBOX_XAPP_TOKEN = self::SECTION . self::GROUP . 'sandboxtoken';
    const CONFIG_SANDBOX_CUSTOMER_ID = self::SECTION . self::GROUP . 'sandboxcustomerid';

    const CONFIG_PRODUCTION_API_URL = self::SECTION . self::GROUP . 'productionapiurl';
    const CONFIG_PRODUCTION_XAPP_TOKEN = self::SECTION . self::GROUP . 'productiontoken';
    const CONFIG_PRODUCTION_CUSTOMER_ID = self::SECTION . self::GROUP . 'productioncustomerid';

    const CONFIG_DELIVERY_TYPE = self::SECTION . self::GROUP . 'deliverytype';
    const CONFIG_DEPOSIT_ID = self::SECTION . self::GROUP . 'depositid';

    const CONFIG_IVA_CALCULATE = self::SECTION . self::GROUP . 'ivacalculate';

    const CONFIG_SIZE_HEIGHT_ID = self::SECTION . self::GROUP . 'sizeheight';
    const CONFIG_SIZE_WIDTH_ID = self::SECTION . self::GROUP . 'sizewidth';
    const CONFIG_SIZE_DEPTH_ID = self::SECTION . self::GROUP . 'sizedepth';
    const CONFIG_WEIGHT_UNIT_ID = self::SECTION . self::GROUP . 'weightunit';

    const CONFIG_COUNTRY_RESTRICTION = self::SECTION . self::GROUP . 'sallowspecific';

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
    public function isEnabled()
    {
        return $this->getConfigValue(self::CONFIG_MODULE_ENABLED);
    }

    /**
     * Return Method Name
     *
     * @return mixed
     */
    public function getMethodName()
    {
        return $this->getConfigValue(self::CONFIG_METHOD_NAME);
    }

    /**
     * Get Bluemail Sandbox State
     *
     * @return mixed
     */
    public function getSandboxState()
    {
        return $this->getConfigValue(self::CONFIG_SANDBOX_ENABLED);
    }

    /**
     * Get Bluemail X-Midla-App-Token
     *
     * @return mixed
     */
    public function getAppToken()
    {
        if ($this->getSandboxState()) {
            $appToken = self::CONFIG_SANDBOX_XAPP_TOKEN;
        } else {
            $appToken = self::CONFIG_PRODUCTION_XAPP_TOKEN;
        }

        return $this->getConfigValue($appToken);
    }

    /**
     * Get Bluemail Customer ID
     *
     * @return mixed
     */
    public function getCustomerId()
    {
        if ($this->getSandboxState()) {
            $customerId = self::CONFIG_SANDBOX_CUSTOMER_ID;
        } else {
            $customerId = self::CONFIG_PRODUCTION_CUSTOMER_ID;
        }

        return $this->getConfigValue($customerId);
    }

    /**
     * Get API URL
     *
     * @return mixed
     */
    public function getApiUrl()
    {
        if ($this->getSandboxState()) {
            $apiUrl = self::CONFIG_SANDBOX_API_URL;
        } else {
            $apiUrl = self::CONFIG_PRODUCTION_API_URL;
        }

        return $this->getConfigValue($apiUrl);
    }

    /**
     * Get Delivery Type
     *
     * @return mixed
     */
    public function getDeliveryType()
    {
        return $this->getConfigValue(self::CONFIG_DELIVERY_TYPE);
    }

    /**
     * Get Deposit Id
     *
     * @return mixed
     */
    public function getDepositId()
    {
        return $this->getConfigValue(self::CONFIG_DEPOSIT_ID);
    }

    /**
     * Get Size Height Attribute Id
     *
     * @return mixed
     */
    public function getSizeHeightAttributeId()
    {
        return $this->getConfigValue(self::CONFIG_SIZE_HEIGHT_ID);
    }

    /**
     * Get Size Width Attribute Id
     *
     * @return mixed
     */
    public function getSizeWidthAttributeId()
    {
        return $this->getConfigValue(self::CONFIG_SIZE_WIDTH_ID);
    }

    /**
     * Get Size Depth Attribute Id
     *
     * @return mixed
     */
    public function getSizeDepthAttributeId()
    {
        return $this->getConfigValue(self::CONFIG_SIZE_DEPTH_ID);
    }

    /**
     * Get Weight Unit
     *
     * @return mixed
     */
    public function getWeightUnit()
    {
        return $this->getConfigValue(self::CONFIG_WEIGHT_UNIT_ID);
    }

    /**
     * Get Country Restrictions
     *
     * @return mixed
     */
    public function getCountryRestrictions()
    {
        return $this->getConfigValue(self::CONFIG_COUNTRY_RESTRICTION);
    }

    /**
     * Get Country Restrictions
     *
     * @return mixed
     */
    public function getIvaTaxCalculate()
    {
        return $this->getConfigValue(self::CONFIG_IVA_CALCULATE);
    }

    /**
     * Get Debugger State
     *
     * @return mixed
     */
    public function getDebuggerState()
    {
        return $this->getConfigValue(self::CONFIG_DEBUGGER_ENABLED);
    }

    public function getBlueMailUrl()
    {
        if ($this->getSandboxState()) {
            return self::BLUEMAIL_URL_SANDBOX;
        } else {
            return self::BLUEMAIL_URL;
        }
    }
    /**
     * Return specific config value based on path
     *
     * @param $path
     * @param null $storeCode
     * @return mixed
     */
    private function getConfigValue(
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
