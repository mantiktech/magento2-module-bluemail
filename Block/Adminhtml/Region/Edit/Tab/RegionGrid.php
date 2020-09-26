<?php
/**
 * Copyright ©  2020. Mantik Tech.  All rights reserved under CC BY-NC-SA 4.0 licence.
 * See LICENSE file for more details.
 * @link https://www.mantik.tech/
 */

namespace Mantik\Bluemail\Block\Adminhtml\Region\Edit\Tab;

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Grid\Column\Renderer\Options\Converter;
use Magento\Backend\Block\Widget\Grid\Extended;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Backend\Helper\Data;
use Magento\Directory\Model\ResourceModel\Region\CollectionFactory as RegionCollectionFactory;
use Mantik\Bluemail\Model\Config\Source\Departement as DepartementSource;

/**
 * Class RegionGrid
 * @package Mantik\Bluemail\Block\Adminhtml\Region\Edit\Tab
 */
class RegionGrid extends Extended implements TabInterface
{
    /**
     * @var RegionCollectionFactory
     */
    protected $regionCollectionFactory;

    /**
     * @var DepartementSource
     */
    protected $departementSource;

    /**
     * @var Converter
     */
    protected $converter;

    /**
     * RegionGrid constructor.
     *
     * @param Context                 $context
     * @param Data                    $backendHelper
     * @param array                   $data
     * @param RegionCollectionFactory $regionCollectionFactory
     * @param DepartementSource       $departementSource
     * @param Converter               $converter
     */
    public function __construct(
        Context $context,
        Data $backendHelper,
        array $data = [],
        RegionCollectionFactory $regionCollectionFactory,
        DepartementSource $departementSource,
        Converter $converter
    ) {
        parent::__construct($context, $backendHelper, $data);
        $this->regionCollectionFactory = $regionCollectionFactory;
        $this->departementSource = $departementSource;
        $this->converter = $converter;
    }

    /**
     *
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('regionGrid');
        $this->setDefaultLimit(30);
        $this->setSaveParametersInSession(true);
        $this->setFilterVisibility(false);
        $this->setUseAjax(true);
    }

    /**
     * @return Extended
     */
    protected function _prepareCollection()
    {
        $regionCollection = $this->regionCollectionFactory->create();
        $regionCollection->addFieldToFilter('country_id', 'AR'); //TODO maybe make it an option, at least some class constant?
        $regionLinkTable = $regionCollection->getResource()->getTable('bluemail_region_link');
        $regionCollection
            ->getSelect()
            ->joinLeft(
                ['bluemail_region_link' => $regionLinkTable],
                'main_table.region_id = bluemail_region_link.magento_region_id',
                ['bluemail_region_id' => 'bluemail_region_link.bluemail_region_id']
            );
        $regionCollection->addFilterToMap('bluemail_region_id', 'bluemail_region_link.bluemail_region_id');
        $this->setCollection($regionCollection);

        return parent::_prepareCollection();
    }

    /**
     * @return Extended
     * @throws \Exception
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'region_id',
            [
                'header'           => __('Region ID'),
                'type'             => 'number',
                'index'            => 'region_id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id',
            ]
        );
        $this->addColumn(
            'default_name',
            [
                'header' => __('Magento Name'),
                'index'  => 'default_name',
                'class'  => 'xxx',
                'width'  => '50px',
            ]
        );
        $this->addColumn(
            'bluemail_region_id',
            [
                'header' => __('Bluemail Name'),
                'index'  => 'bluemail_region_id',
                'type'   => 'select',
                'edit' => true,
                'class'  => 'xxx',
                'width'  => '50px',
                'options' => $this->converter->toFlatArray($this->departementSource->toOptionArray())
            ]
        );

        return parent::_prepareColumns();
    }

    /**
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/regiongrid', ['_current' => true]);
    }

    /**
     * @param \Magento\Catalog\Model\Product|\Magento\Framework\DataObject $row
     *
     * @return string
     */
    public function getRowUrl($row)
    {
        return '';
    }

    /**
     * @return array
     */
    protected function _getSelectedProducts()
    {
        $products = $this->getRequest()->getPost('selected_products');
        if ($products === null) {
            $slider = $this->getSlider();
            $productIds = $slider->getProductIds() ? explode('&', $slider->getProductIds()) : [];
            return $productIds;
        }
        return $products;
    }

    /**
     * @return Slider
     */
    public function getSlider()
    {
        $sliderId = $this->getRequest()->getParam('id');
        $slider = $this->_sliderFactory->create();
        if ($sliderId) {
            $slider->load($sliderId);
        }

        return $slider;
    }

    /**
     * @return array
     */
    public function getSelectedProducts()
    {
        $slider = $this->getSlider();
        $selected = $slider->getProductIds() ? explode('&', $slider->getProductIds()) : [];

        if (!is_array($selected)) {
            $selected = [];
        }

        return $selected;
    }

    /**
     * @return string
     */
    public function getTabLabel()
    {
        return __('Region Link');
    }

    /**
     * @return bool
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * @return string
     */
    public function getTabTitle()
    {
        return $this->getTabLabel();
    }

    /**
     * @return bool
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * @return string
     */
    public function getTabUrl()
    {
        return $this->getUrl('bluemail/region/region', ['_current' => true]);
    }

    /**
     * @return string
     */
    public function getTabClass()
    {
        return 'ajax only';
    }
}
