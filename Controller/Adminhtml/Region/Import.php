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
use Mantik\Bluemail\Api\Data\RegionLinkInterfaceFactory;
use Mantik\Bluemail\Api\RegionLinkRepositoryInterface;
use Magento\Directory\Model\RegionFactory;
use Mantik\Bluemail\Model\Config\Source\Departement as DepartementSource;

/**
 * Class Import
 * @package Mantik\Bluemail\Controller\Adminhtml\Region
 */
class Import extends Action implements HttpPostActionInterface
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
     * @var RegionFactory
     */
    protected $regionFactory;

    /**
     * @var DepartementSource
     */
    protected $departementSource;

    /**
     * Save constructor.
     *
     * @param Context                       $context
     * @param RegionLinkInterfaceFactory    $regionLinkFactory
     * @param RegionLinkRepositoryInterface $regionLinkRepository
     * @param RegionFactory                 $regionFactory
     * @param DepartementSource             $departementSource
     */
    public function __construct(
        Context $context,
        RegionLinkInterfaceFactory $regionLinkFactory,
        RegionLinkRepositoryInterface $regionLinkRepository,
        RegionFactory $regionFactory,
        DepartementSource $departementSource
    ) {
        parent::__construct($context);
        $this->regionLinkFactory = $regionLinkFactory;
        $this->regionLinkRepository = $regionLinkRepository;
        $this->regionFactory = $regionFactory;
        $this->departementSource = $departementSource;
    }

    public function execute()
    {
        try {
            $departments = $this->departementSource->toOptionArray();//TODO use actual department model instead of option source
            $counter = 0;
            foreach ($departments as $department) {
                if (!empty($department['value']) && !empty($department['label'])) { //TODO Check if region link is already created
                    $counter++;
                    $countryCode = 'AR'; //TODO maybe make it into a config?
                    $region = $this->regionFactory
                        ->create()
                        ->setCountryId($countryCode)
                        ->setDefaultName($department['label'])
                        ->setCode($countryCode . '-' . $counter);
                    $region->getResource()->save($region);//TODO also create directory_country_region_name entry

                    $regionLink = $this->regionLinkFactory
                        ->create()
                        ->setMagentoRegionId($region->getId())
                        ->setBluemailRegionId($department['value']);
                    $this->regionLinkRepository->save($regionLink);
                }
            }
            $this->messageManager->addSuccessMessage(__('Regions imported successfully'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('*/*');
        return $resultRedirect;
    }
}
