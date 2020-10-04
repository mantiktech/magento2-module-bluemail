<?php
/**
 * Copyright ©  2020. Mantik Tech.  All rights reserved under CC BY-NC-SA 4.0 licence.
 * See LICENSE file for more details.
 * @link https://www.mantik.tech/
 */

namespace Mantik\Bluemail\Model\Carrier;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory;
use Magento\Quote\Model\Quote\Address\RateResult\MethodFactory;
use Magento\Shipping\Model\Carrier\AbstractCarrier;
use Magento\Shipping\Model\Carrier\CarrierInterface;
use Magento\Shipping\Model\Rate\ResultFactory;
use Mantik\Bluemail\Helper\Config;
use  Mantik\Bluemail\Helper\Data;
use Mantik\Bluemail\Model\BluemailApi\Estimates;
use  Psr\Log\LoggerInterface;

/**
 * Class Bluemail
 */
class Bluemail extends AbstractCarrier implements CarrierInterface
{

    /**
     * @var string
     */
    protected $_code = 'bluemail';

    /**
     * @var bool
     */
    protected $_isFixed = true;

    /**
     * @var ResultFactory
     */
    protected $_rateResultFactory;

    /**
     * @var MethodFactory
     */
    protected $_rateMethodFactory;

    /**
     * @var Data
     */
    protected $helper;

    /**
     * @var Estimates
     */
    protected $estimates;

    /**
     * @var Config
     */
    protected $config;

    /**
     * Constructor
     *
     * @param ScopeConfigInterface $scopeConfig
     * @param ErrorFactory $rateErrorFactory
     * @param LoggerInterface $logger
     * @param ResultFactory $rateResultFactory
     * @param MethodFactory $rateMethodFactory
     * @param Estimates $estimates
     * @param Data $helper
     * @param Config $config
     * @param array $data
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        ErrorFactory $rateErrorFactory,
        LoggerInterface $logger,
        ResultFactory $rateResultFactory,
        MethodFactory $rateMethodFactory,
        Estimates $estimates,
        Data $helper,
        Config $config,
        array $data = []
    ) {
        $this->_rateResultFactory = $rateResultFactory;
        $this->_rateMethodFactory = $rateMethodFactory;
        $this->estimates = $estimates;
        $this->helper = $helper;
        $this->config = $config;
        parent::__construct($scopeConfig, $rateErrorFactory, $logger, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function collectRates(RateRequest $request)
    {
        if (!$this->getConfigFlag('active') || $request->getPackageQty() == 0) {
            return false;
        }

        $result = $this->_rateResultFactory->create();

        $method = $this->createMethod();
        if ($request->getFreeShipping() === true) {
            $method->setCarrier($this->_code);
            $method->setCarrierTitle($this->getConfigData('name'));
            $method->setMethodTitle(__('Free shipping'));
            $method->setMethod($this->_code);
            $shippingPrice = '0.00';
            $method->setCost($shippingPrice);
            $result->append($method);
        } else {
            $this->estimates->execute(['destZip'=>$request->getDestPostcode(),
                                       'Packages'=> $this->helper->getPackages($request->getAllItems())
                                      ]);

            $methods = $this->estimates->getResponse();
            if (!empty($methods['Prices'])) {
                foreach ($methods['Prices'] as $item) {
                    if (in_array($item['deliveryType'], explode(',', $this->config->getDeliveryType()))) {
                        $method = $this->createMethod();
                        $method->setMethodTitle($item['name']);
                        $method->setMethod($item['code']);
                        $method->setPrice($item['price']);
                        $method->setCost($item['price']);
                        $result->append($method);
                    }
                }
            }
        }
        return $result;
    }

    /**
     * getAllowedMethods
     *
     * @return array
     */
    public function getAllowedMethods()
    {
        return [$this->_code => $this->getConfigData('name')];
    }
    private function createMethod()
    {
        $method = $this->_rateMethodFactory->create();
        $method->setCarrier($this->_code);
        return $method->setCarrierTitle($this->getConfigData('name'));
    }
}
