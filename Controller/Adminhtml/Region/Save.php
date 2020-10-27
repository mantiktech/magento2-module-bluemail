<?php
/**
 * Copyright ©  2020. Mantik Tech.  All rights reserved under CC BY-NC-SA 4.0 licence.
 * See LICENSE file for more details.
 * @link https://www.mantik.tech/
 */

namespace Mantik\Bluemail\Controller\Adminhtml\Region;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Serialize\SerializerInterface;
use Mantik\Bluemail\Api\Data\RegionLinkInterfaceFactory;
use Mantik\Bluemail\Api\RegionLinkRepositoryInterface;

/**
 * Class Save
 * @package Mantik\Bluemail\Controller\Adminhtml\Region
 */
class Save extends Action implements HttpPostActionInterface
{
    /**
     * @var RegionLinkInterfaceFactory
     */
    protected $regionLinkFactory;

    /**
     * @var RegionLinkRepositoryInterface
     */
    protected $regionLinkRepository;

    /**
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * Save constructor.
     *
     * @param Context                       $context
     * @param RegionLinkInterfaceFactory    $regionLinkFactory
     * @param RegionLinkRepositoryInterface $regionLinkRepository
     * @param SerializerInterface           $serializer
     */
    public function __construct(
        Context $context,
        RegionLinkInterfaceFactory $regionLinkFactory,
        RegionLinkRepositoryInterface $regionLinkRepository,
        SerializerInterface $serializer
    ) {
        parent::__construct($context);
        $this->regionLinkFactory = $regionLinkFactory;
        $this->regionLinkRepository = $regionLinkRepository;
        $this->serializer = $serializer;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $serializedRegionLinks = $this->getRequest()->getParam('region_links');
        $regionLinks = $this->serializer->unserialize($serializedRegionLinks);

        try {
            foreach ($regionLinks as $magentoRegionId => $bluemailRegionId) {
                if (empty($bluemailRegionId)) {
                    try {
                        $this->regionLinkRepository->deleteByMagentoRegionId($magentoRegionId);
                    } catch (NoSuchEntityException $e) {
                        continue;
                    }
                } else {
                    try {
                        $regionLink = $this->regionLinkRepository->getByMagentoRegionId($magentoRegionId);
                    } catch (NoSuchEntityException $e) {
                        $regionLink = $this->regionLinkFactory
                            ->create()
                            ->setMagentoRegionId($magentoRegionId);
                    }
                    if ($regionLink->getBluemailRegionId() != $bluemailRegionId) {
                        $regionLink->setBluemailRegionId($bluemailRegionId);
                        $this->regionLinkRepository->save($regionLink);
                    }
                }
            }
            $this->messageManager->addSuccessMessage(__('Region Links were saved successfully'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('*/*');
        return $resultRedirect;
    }
}
