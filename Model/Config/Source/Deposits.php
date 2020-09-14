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
use Mantik\Bluemail\Model\BluemailApi\Pickup;

/**
 * Class Deposits
 */
class Deposits implements OptionSourceInterface
{
    // TODO: Add request to api for deposit list
    /**
     * @var Pickup
     */
    private $bmPickup;

    /**
     * Deposits constructor.
     *
     * @param Pickup $bmPickup
     */
    public function __construct(
        Pickup $bmPickup
    ) {
        $this->bmPickup = $bmPickup;
    }

    /**
     * Return options array
     *`
     * @return array|array[]
     */
    public function toOptionArray()
    {
        return [
            [
                'value' => '',
                'label' => __('Select one option ...')
            ]
        ];
    }
}
