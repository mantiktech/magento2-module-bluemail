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
use Magento\Sales\Model\ShipOrder;
use Magento\Sales\Model\Convert\Order;


class MassShip extends AbstractMassAction implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'Mantik_Bluemail::mass_ship';

    /**
     * @var \Magento\Sales\Model\ShipOrder
     */
    protected $shipOrderService;

    /**
     * @var \Magento\Sales\Model\Convert\Order
     */
    protected $orderConverter;

    /**
     * Class constructor
     *
     * @param Context           $context
     * @param Filter            $filter
     * @param CollectionFactory $collectionFactory
     * @param ShipOrder $shipOrderService
     * @param Order $orderConverter
     */

    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        ShipOrder $shipOrderService,
        Order $orderConverter
    ) {
        parent::__construct($context, $filter);
        $this->collectionFactory = $collectionFactory;
        $this->shipOrderService = $shipOrderService;
        $this->orderConverter = $orderConverter;
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
            if ($order->canShip()) {
                try {
                    $orderId = $order->getId();
                    $shippedItems = $this->createShipmentItems($order);
                    //creates shipment
                    $this->shipOrderService->execute($orderId, $shippedItems);
                } catch (\Exception $e) {
                    echo $e->getMessage();
                }


            }
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

    /**
     * Create shipment items required to create shipment.
     *
     * @param \Magento\Sales\Model\Order $order
     *
     * @return array
     */
    protected function createShipmentItems($order)
    {
        $shipmentItem = [];
        foreach ($order->getAllItems() as $orderItem) {

            $shipmentItem[] = $this->orderConverter
                ->itemToShipmentItem($orderItem)
                ->setQty($orderItem->getQtyOrdered());

        }

        return $shipmentItem;
    }
}
