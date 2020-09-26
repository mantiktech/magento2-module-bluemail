<?php
/**
 * Copyright ©  2020. Mantik Tech.  All rights reserved under CC BY-NC-SA 4.0 licence.
 * See LICENSE file for more details.
 * @link https://www.mantik.tech/
 */

namespace Mantik\Bluemail\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface RegionLinkInterface extends ExtensibleDataInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /**
     * @return int
     */
    public function getMagentoRegionId();

    /**
     * @param int $magentoRegionId
     * @return $this
     */
    public function setMagentoRegionId($magentoRegionId);

    /**
     * @return int
     */
    public function getBluemailRegionId();

    /**
     * @param int $bluemailRegionId
     * @return $this
     */
    public function setBluemailRegionId($bluemailRegionId);
}