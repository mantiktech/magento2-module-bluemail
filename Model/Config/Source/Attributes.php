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
use Magento\Eav\Model\ResourceModel\Entity\Attribute\Collection;
use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class Attributes
 */
class Attributes implements OptionSourceInterface
{
    const FRONTEND_INPUT_TYPE_SELECT = 'text';

    /**
     * @var Collection
     */
    private $attributeCollection;

    /**
     * @var $attributeFilterValue
     */
    private $attributeFilterValue;

    /**
     * Attributes constructor.
     *
     * @param Collection $attributeCollection
     */
    public function __construct(
        Collection $attributeCollection
    ) {
        $this->attributeCollection = $attributeCollection;
        $this->attributeFilterValue = self::FRONTEND_INPUT_TYPE_SELECT;
    }

    /**
     * Get all attributes that match the filter's value
     *
     * @return array
     */
    public function getAllAttributes()
    {
        $this->attributeCollection->addFieldToFilter(
            AttributeInterface::FRONTEND_INPUT, $this->attributeFilterValue
        );

        return $this->attributeCollection->load()->getData();;
    }

    /**
     * Return options array
     *
     * @return array
     */
    public function toOptionArray()
    {
        $attributesArray  = $this->getAllAttributes();
        $options = array(['value' => '', 'label' => __('Select an attribute ...')]);

        foreach ($attributesArray as $key => $value) {
            array_push($options, ['value' => $value['attribute_id'], 'label' => $value['frontend_label']]);
        }

        return $options;
    }
}

