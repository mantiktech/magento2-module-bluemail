<?php
/**
 * Copyright ©  2020. Mantik Tech.  All rights reserved under CC BY-NC-SA 4.0 licence.
 * See LICENSE file for more details.
 * @link https://www.mantik.tech/
 */

namespace Mantik\Bluemail\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class RegionLink
 * @package Mantik\Bluemail\Model\ResourceModel
 */
class RegionLink extends AbstractDb
{
    /**
     *
     */
    protected function _construct()
    {
        $this->_init('bluemail_region_link', 'link_id');
    }

    /**
     * @param $magentoRegionId
     *
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getIdByMagentoRegionId($magentoRegionId)
    {
        $connection = $this->getConnection();

        $select = $connection->select()->from($this->getMainTable(), 'link_id')->where('magento_region_id = :magentoRegionId');

        $bind = [':magentoRegionId' => (string)$magentoRegionId];

        return $connection->fetchOne($select, $bind);
    }
}
