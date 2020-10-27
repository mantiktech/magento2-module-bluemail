<?php
/**
 * Copyright ©  2020. Mantik Tech.  All rights reserved under CC BY-NC-SA 4.0 licence.
 * See LICENSE file for more details.
 * @link https://www.mantik.tech/
 */

namespace Mantik\Bluemail\Model;

use Magento\Framework\Model\AbstractExtensibleModel;
use Mantik\Bluemail\Api\Data\RegionLinkInterface;
use Mantik\Bluemail\Model\ResourceModel\RegionLink as ResourceModel;

/**
 * Class RegionLink
 * @package Mantik\Bluemail\Model
 */
class RegionLink extends AbstractExtensibleModel implements RegionLinkInterface
{

    const LINK_ID = 'link_id';

    const MAGENTO_REGION_ID = 'magento_region_id';

    const BLUEMAIL_REGION_ID = 'bluemail_region_id';

    /**
     * @var string
     */
    protected $_idFieldName = self::LINK_ID;

    /**
     *
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    /**
     * @return int|mixed
     */
    public function getMagentoRegionId()
    {
        return $this->_getData(self::MAGENTO_REGION_ID);
    }

    /**
     * @param int $magentoRegionId
     *
     * @return RegionLinkInterface|RegionLink
     */
    public function setMagentoRegionId($magentoRegionId)
    {
        return $this->setData(self::MAGENTO_REGION_ID, $magentoRegionId);
    }

    /**
     * @return int|mixed
     */
    public function getBluemailRegionId()
    {
        return $this->_getData(self::BLUEMAIL_REGION_ID);
    }

    /**
     * @param int $bluemailRegionId
     *
     * @return RegionLinkInterface|RegionLink
     */
    public function setBluemailRegionId($bluemailRegionId)
    {
        return $this->setData(self::BLUEMAIL_REGION_ID, $bluemailRegionId);
    }
}
