<?php
/**
 * Copyright ©  2020. Mantik Tech.  All rights reserved under CC BY-NC-SA 4.0 licence.
 * See LICENSE file for more details.
 * @link https://www.mantik.tech/
 */

namespace Mantik\Bluemail\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Mantik\Bluemail\Api\Data\RegionLinkInterface;
use Mantik\Bluemail\Api\RegionLinkRepositoryInterface;
use Mantik\Bluemail\Api\Data\RegionLinkSearchResultsInterface;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class RegionRepository
 * @package Mantik\Bluemail\Model
 */
class RegionLinkRepository implements RegionLinkRepositoryInterface
{
    /**
     * @var ResourceModel\RegionLink
     */
    protected $resourceModel;

    /**
     * @var RegionLinkFactory
     */
    protected $regionLinkFactory;

    /**
     * @var ResourceModel\RegionLink\CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var RegionLinkSearchResultsInterface
     */
    protected $searchResultFactory;

    /**
     * RegionRepository constructor.
     *
     * @param ResourceModel\RegionLink                   $resourceModel
     * @param RegionLinkFactory                          $regionLinkFactory
     * @param ResourceModel\RegionLink\CollectionFactory $collectionFactory
     * @param RegionLinkSearchResultsInterface           $searchResultFactory
     */
    public function __construct(
        ResourceModel\RegionLink $resourceModel,
        RegionLinkFactory $regionLinkFactory,
        ResourceModel\RegionLink\CollectionFactory $collectionFactory,
        RegionLinkSearchResultsInterface $searchResultFactory
    ) {
        $this->resourceModel = $resourceModel;
        $this->regionLinkFactory = $regionLinkFactory;
        $this->collectionFactory = $collectionFactory;
        $this->searchResultFactory = $searchResultFactory;
    }

    /**
     * @param int $id
     *
     * @return RegionLinkInterface|ResourceModel\RegionLink
     * @throws NoSuchEntityException
     */
    public function getById($id)
    {
        $regionLink = $this->regionLinkFactory->create();
        $this->resourceModel->load($regionLink, $id);
        if (!$regionLink->getId()) {
            throw new NoSuchEntityException(__('Region link with ID %1 doesn\'t exist. Verify and try again."', $id));
        }
        return $regionLink;
    }

    /**
     * @param int $magentoRegionId
     *
     * @return RegionLinkInterface|ResourceModel\RegionLink
     * @throws NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getByMagentoRegionId($magentoRegionId)
    {
        $linkId = $this->resourceModel->getIdByMagentoRegionId($magentoRegionId);
        if (!$linkId) {
            throw new NoSuchEntityException(__('Region link with Magento Region ID %1 doesn\'t exist. Verify and try again."', $magentoRegionId));
        }
        return $this->getById($linkId);
    }

    /**
     * @param RegionLinkInterface $regionLink
     *
     * @return RegionLinkInterface|ResourceModel\RegionLink
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function save(RegionLinkInterface $regionLink)
    {
        return $this->resourceModel->save($regionLink);
    }

    /**
     * @param RegionLinkInterface $regionLink
     *
     * @return bool
     * @throws \Magento\Framework\Exception\StateException
     */
    public function delete(RegionLinkInterface $regionLink)
    {
        try {
            $this->resourceModel->delete($regionLink);
        } catch (\Exception $e) {
            throw new \Magento\Framework\Exception\StateException(
                __('Region link with Magento Region ID %1 couldn\'t be removed.', $regionLink->getMagentoRegionId()),
                $e
            );
        }
        return true;
    }

    /**
     * @param int $magentoRegionId
     *
     * @return bool|true
     * @throws NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\StateException
     */
    public function deleteByMagentoRegionId($magentoRegionId)
    {
        $regionLink = $this->getByMagentoRegionId($magentoRegionId);
        return $this->delete($regionLink);
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     *
     * @return RegionLinkSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->collectionFactory->create();

        $this->addFiltersToCollection($searchCriteria, $collection);
        $this->addSortOrdersToCollection($searchCriteria, $collection);
        $this->addPagingToCollection($searchCriteria, $collection);

        $collection->load();

        return $this->buildSearchResult($searchCriteria, $collection);
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @param Collection              $collection
     */
    private function addFiltersToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            $fields = $conditions = [];
            foreach ($filterGroup->getFilters() as $filter) {
                $fields[] = $filter->getField();
                $conditions[] = [$filter->getConditionType() => $filter->getValue()];
            }
            $collection->addFieldToFilter($fields, $conditions);
        }
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @param Collection              $collection
     */
    private function addSortOrdersToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        foreach ((array) $searchCriteria->getSortOrders() as $sortOrder) {
            $direction = $sortOrder->getDirection() == SortOrder::SORT_ASC ? 'asc' : 'desc';
            $collection->addOrder($sortOrder->getField(), $direction);
        }
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @param Collection              $collection
     */
    private function addPagingToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        $collection->setPageSize($searchCriteria->getPageSize());
        $collection->setCurPage($searchCriteria->getCurrentPage());
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @param Collection              $collection
     *
     * @return mixed
     */
    private function buildSearchResult(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        $searchResults = $this->searchResultFactory->create();

        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }
}
