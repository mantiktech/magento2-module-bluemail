<?php
/**
 * Copyright ©  2020. Mantik Tech.  All rights reserved under CC BY-NC-SA 4.0 licence.
 * See LICENSE file for more details.
 * @link https://www.mantik.tech/
 */

namespace Mantik\Bluemail\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Mantik\Bluemail\Api\Data\RegionLinkInterface;

interface RegionLinkRepositoryInterface
{
    /**
     * @param int $id
     * @return \Mantik\Bluemail\Api\Data\RegionLinkInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($id);

    /**
     * @param int $magentoRegionId
     * @return \Mantik\Bluemail\Api\Data\RegionLinkInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getByMagentoRegionId($magentoRegionId);

    /**
     * @param \Mantik\Bluemail\Api\Data\RegionLinkInterface $regionLink
     * @return \Mantik\Bluemail\Api\Data\RegionLinkInterface
     */
    public function save(RegionLinkInterface $regionLink);

    /**
     * @param \Mantik\Bluemail\Api\Data\RegionLinkInterface $regionLink
     * @return true Will returned True if deleted
     * @throws \Magento\Framework\Exception\StateException
     */
    public function delete(RegionLinkInterface $regionLink);

    /**
     * @param int $magentoRegionId
     * @return true Will returned True if deleted
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\StateException
     */
    public function deleteByMagentoRegionId($magentoRegionId);

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Mantik\Bluemail\Api\Data\RegionLinkSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);
}
