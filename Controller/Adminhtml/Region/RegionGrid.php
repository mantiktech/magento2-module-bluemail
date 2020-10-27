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
use Magento\Framework\View\Result\LayoutFactory;

/**
 * Class RegionGrid
 * @package Mantik\Bluemail\Controller\Adminhtml\Region
 */
class RegionGrid extends Action implements HttpPostActionInterface
{
    /**
     * @var LayoutFactory
     */
    protected $resultLayoutFactory;

    /**
     * RegionGrid constructor.
     *
     * @param Context       $context
     * @param LayoutFactory $resultLayoutFactory
     */
    public function __construct(
        Context $context,
        LayoutFactory $resultLayoutFactory
    ) {
        $this->resultLayoutFactory = $resultLayoutFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Layout
     */
    public function execute()
    {
        $resultLayout = $this->resultLayoutFactory->create();
        return $resultLayout;
    }
}
