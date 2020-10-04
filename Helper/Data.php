<?php
/**
 * Copyright ©  2020. Mantik Tech.  All rights reserved under CC BY-NC-SA 4.0 licence.
 * See LICENSE file for more details.
 * @link https://www.mantik.tech/
 */

declare(strict_types=1);

namespace Mantik\Bluemail\Helper;

use Magento\Catalog\Model\ProductFactory;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\StoreManagerInterface;
use Mantik\Bluemail\Api\RegionLinkRepositoryInterface;

class Data extends AbstractHelper
{
    protected $configHelper;
    protected $storeManager;
    protected $productFactory;
    protected $regionLinkRepositoryInterface;

    /**
     * @param Context $context
     * @param Config $config
     * @param StoreManagerInterface $storeManager
     * @param ProductFactory $productFactory
     * @param RegionLinkRepositoryInterface $regionLinkRepositoryInterface
     */
    public function __construct(
        Context $context,
        Config $config,
        StoreManagerInterface $storeManager,
        ProductFactory $productFactory,
        RegionLinkRepositoryInterface $regionLinkRepositoryInterface
    ) {
        parent::__construct($context);

        $this->configHelper = $config;
        $this->storeManager = $storeManager;
        $this->productFactory = $productFactory;
        $this->regionLinkRepositoryInterface = $regionLinkRepositoryInterface;
    }

    public function getPackages($items)
    {
        $package=[];

        foreach ($items as $item) {
            $height = 0;
            $width = 0;
            $depth = 0;

            $product= empty($item->getProduct()) ? $this->productFactory->create()->load($item->getProductId()) : $item->getProduct();

            if ($this->configHelper->getSizeHeightAttributeId()) {
                $height = $product->getResource()->getAttributeRawValue($product->getId(), $this->configHelper->getSizeHeightAttributeId(), $this->storeManager->getStore()->getId());
            }
            if ($this->configHelper->getSizeHeightAttributeId()) {
                $width = $product->getResource()->getAttributeRawValue($product->getId(), $this->configHelper->getSizeWidthAttributeId(), $this->storeManager->getStore()->getId());
            }
            if ($this->configHelper->getSizeHeightAttributeId()) {
                $depth = $product->getResource()->getAttributeRawValue($product->getId(), $this->configHelper->getSizeDepthAttributeId(), $this->storeManager->getStore()->getId());
            }
            $package[]=[
                "weight"=> $this->weightToKg($item->getWeight()),
                "weightUnit"=> 'KG',
                "sizeHeight"=> round($height/100, 2),
                "sizeWidth"=> round($width/100, 2),
                "sizeDepth"=> round($depth/100, 2),
                "declaredValue"=> $item->getPrice(),
                "quantity" => $item->getQty()
            ];
        }
        return $package;
    }

    public function getDestination($order)
    {
        $street = $order->getShippingAddress()->getStreet();
        return [
            'destName' => $order->getShippingAddress()->getName(),
            'destCode' => $order->getShippingAddress()->getVatId() ? $order->getShippingAddress()->getVatId() : $order->getBillingAddress()->getVatId(),
            'destCodeType' => 'DNI',
            'destEmail' => $order->getShippingAddress()->getEmail(),
            'destStreetName' => $street[0],
            'destStreetNumber' => isset($street[1]) ? $street[1] : '',
            'destZip' => $order->getShippingAddress()->getPostCode(),
            'destTown' => $order->getShippingAddress()->getCity(),
            'destDepartmentId' => $this->regionLinkRepositoryInterface->getByMagentoRegionId($order->getShippingAddress()->getRegionId())->getBluemailRegionId(),
            'destCountryId' => Config::DEFAULT_COUNTRY,
            'destPhone' => $order->getShippingAddress()->getTelephone()
        ];
    }
    public function weightToKg($weight)
    {
        switch ($this->configHelper->getWeightUnit()) {
            case 'lb':
                $weight = $weight*.454;
        }
        return $weight;
    }
}
