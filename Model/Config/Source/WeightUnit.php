<?php
/**
 * Copyright ©  2020. Mantik Tech.
 * All rights reserved under CC BY-NC-SA 4.0 licence.
 * See LICENSE file for more details.
 * @link https://www.mantik.tech/
 */

declare(strict_types=1);

namespace Mantik\Bluemail\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class WeightUnit
 */
class WeightUnit implements OptionSourceInterface
{
    /**
     * Return weight units
     *
     * @return array|array[]
     */
    public function toOptionArray()
    {
        return [
            ['value' => 'kg', 'label' => __('KG')],
            ['value' => 'lb', 'label' => __('LB')]
        ];
    }
}
