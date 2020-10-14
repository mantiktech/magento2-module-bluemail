<?php
/**
 * Copyright ©  2020. Mantik Tech.
 * All rights reserved under CC BY-NC-SA 4.0 licence.
 * See LICENSE file for more details.
 * @link https://www.mantik.tech/
 */

declare(strict_types=1);

namespace Mantik\Bluemail\Model\Config\Source;

use Magento\Eav\Api\Data\AttributeInterface;

use Magento\Catalog\Model\ResourceModel\Product\Attribute\CollectionFactory;
use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class Attributes
 */
class Attributes implements OptionSourceInterface
{
    const FRONTEND_INPUT_TYPE_SELECT = 'text';

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * Attributes constructor.
     *
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        CollectionFactory $collectionFactory
    ) {
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Get all attributes that match the filter's value
     *
     * @return array
     */
    public function getAttributes()
    {
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter(
            AttributeInterface::FRONTEND_INPUT, self::FRONTEND_INPUT_TYPE_SELECT
        );

        $attributesArray = array();

        foreach ($collection as $items) {
            $attributesArray[] = $items->getData();
        }

        return $attributesArray;
    }

    /**
     * Return options array
     *
     * @return array
     */
    public function toOptionArray()
    {
        $attributesArray  = $this->getAttributes();
        $options = array(['value' => '', 'label' => __('Select an attribute ...')]);

        foreach ($attributesArray as $key => $value) {
            array_push($options, ['value' => $value['attribute_code'], 'label' => $value['frontend_label']]);
        }

        return $options;
    }
}

