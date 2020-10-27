<?php
/**
 * Copyright ©  2020. Mantik Tech.  All rights reserved under CC BY-NC-SA 4.0 licence.
 * See LICENSE file for more details.
 * @link https://www.mantik.tech/
 */

namespace Mantik\Bluemail\Block\Adminhtml\Region;

use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Json\EncoderInterface;

/**
 * Class GridSerializer
 * @package Mantik\Bluemail\Block\Adminhtml\Region
 */
class GridSerializer extends Template
{
    /**
     * @var
     */
    protected $blockGrid;

    /**
     * @var EncoderInterface
     */
    protected $jsonEncoder;

    /**
     * GridSerializer constructor.
     *
     * @param Context          $context
     * @param array            $data
     * @param EncoderInterface $jsonEncoder
     */
    public function __construct(
        Context $context,
        array $data = [],
        EncoderInterface $jsonEncoder
    ) {
        parent::__construct($context, $data);
        $this->jsonEncoder = $jsonEncoder;
    }

    /**
     * @return bool|\Magento\Framework\View\Element\BlockInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getBlockGrid()
    {
        if ($this->blockGrid === null) {
            $this->blockGrid = $this->getLayout()->getBlock('bluemail.region.grid'); //TODO pass grid block name as argument in layout
        }
        return $this->blockGrid;
    }

    /**
     * @return mixed
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getGridJsObjectName()
    {
        return $this->getBlockGrid()->getJsObjectName();
    }

    /**
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getRegionLinksJson()
    {
        /** @var \Mantik\Bluemail\Block\Adminhtml\Region\Edit\Tab\RegionGrid $blockGrid */
        $blockGrid = $this->getBlockGrid();
        $collection = $blockGrid->getCollection();
        $regionLinks = [];
        foreach ($collection as $item) {
            $magentoRegionId = $item->getRegionId();
            $bluemailRegionId = $item->getBluemailRegionId();
            if ($magentoRegionId && $bluemailRegionId) {
                $regionLinks[$magentoRegionId] = $bluemailRegionId;
            }
        }
        return $this->jsonEncoder->encode($regionLinks);
    }
}
