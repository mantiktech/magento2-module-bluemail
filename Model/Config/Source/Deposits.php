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
use Magento\Framework\Serialize\Serializer\Json;
use Mantik\Bluemail\Model\BluemailApi\Stores;

/**
 * Class Deposits
 */
class Deposits implements OptionSourceInterface
{
    /**
     * @var Stores
     */
    private $bmStores;

    /**
     * @var Json
     */
    private $json;

    /**
     * Deposits constructor.
     *
     * @param Stores $bmStores
     */
    public function __construct(
        Stores $bmStores,
        Json $json
    ) {
        $this->bmStores = $bmStores;
        $this->json = $json;
    }

    /**
     * Return options array
     *`
     * @return array|array[]
     */
    public function toOptionArray()
    {
        $options = [];

        $stores = $this->bmStores->getDepositList();
        $decodeStores = $stores;

        foreach ($decodeStores['Stores'] as $key => $store) {
            array_push($options, ['value' => $store['id'], 'label' => $store['name'] . " (" . $store['town'] . ")"]);
        }

        return $options;
    }
}
