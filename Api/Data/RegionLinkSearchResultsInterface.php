<?php
/**
 * Copyright ©  2020. Mantik Tech.  All rights reserved under CC BY-NC-SA 4.0 licence.
 * See LICENSE file for more details.
 * @link https://www.mantik.tech/
 */

namespace Mantik\Bluemail\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface RegionLinkSearchResultsInterface extends SearchResultsInterface
{
    /**
     * @return \Mantik\Bluemail\Api\Data\RegionLinkInterface[]
     */
    public function getItems();

    /**
     * @param \Mantik\Bluemail\Api\Data\RegionLinkInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}