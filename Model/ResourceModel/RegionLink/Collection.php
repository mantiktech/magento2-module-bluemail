<?php
/**
 * Copyright ©  2020. Mantik Tech.  All rights reserved under CC BY-NC-SA 4.0 licence.
 * See LICENSE file for more details.
 * @link https://www.mantik.tech/
 */

namespace Mantik\Bluemail\Model\ResourceModel\RegionLink;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Mantik\Bluemail\Model\RegionLink as Model;
use Mantik\Bluemail\Model\ResourceModel\RegionLink as ResourceModel;

/**
 * Class Collection
 * @package Mantik\Bluemail\Model\ResourceModel\RegionLink
 */
class Collection extends AbstractCollection
{
    /**
     *
     */
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
