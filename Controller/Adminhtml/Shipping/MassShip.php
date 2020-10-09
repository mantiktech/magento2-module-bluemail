<?php
/**
 * Copyright ©  2020. Mantik Tech.  All rights reserved under CC BY-NC-SA 4.0 licence.
 * See LICENSE file for more details.
 * @link https://www.mantik.tech/
 */

namespace Mantik\Bluemail\Controller\Adminhtml\Shipping;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Sales\Controller\Adminhtml\Order\AbstractMassAction;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;
use Magento\Ui\Component\MassAction\Filter;

/**
 * Class MassShip, create shipments for selected items
 *
 * @package Magento\Sales\Controller\Adminhtml\Order
 */
class MassShip extends AbstractMassAction implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'Mantik_Bluemail::mass_ship';

    /**
     * Class constructor
     *
     * @param Context           $context
     * @param Filter            $filter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory
    ) {
        parent::__construct($context, $filter);
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Create shipments for selected items
     *
     * @param AbstractCollection $collection
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    protected function massAction(AbstractCollection $collection)
    {
        foreach ($collection->getItems() as $order) {
            //TODO All yours @jorgevenzon
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('bluemail/shipping');
        return $resultRedirect;
    }

    /**
     * Checking if the user has access to requested component.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return true;
    }
}
