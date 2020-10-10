<?php

namespace Mantik\Bluemail\Ui\Component\Listing\Columns;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Sales\Model\OrderFactory;
use Magento\Sales\Model\ResourceModel\Order;
use Magento\Ui\Component\Listing\Columns\Column;

class BluemailActions extends Column
{
    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var OrderFactory
     */
    protected $orderFactory;

    /**
     * @var OrderResource
     */
    protected $orderResource;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param OrderFactory $orderFactory
     * @param Order $orderResource
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        OrderFactory $orderFactory,
        Order $orderResource,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->orderFactory = $orderFactory;
        $this->orderResource = $orderResource;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item['entity_id'])) {
                    $viewUrlPath = $this->getData('config/viewUrlPath') ?: '#';
                    $urlEntityParamName = $this->getData('config/urlEntityParamName') ?: 'entity_id';
                    $item[$this->getData('name')] = [
                        'view' => [
                            'href' => $this->urlBuilder->getUrl(
                                $viewUrlPath,
                                [
                                    $urlEntityParamName => $item['entity_id']
                                ]
                            ),
                            'label' => __('View')
                        ]
                    ];
                    $order = $this->orderFactory->create();
                    $this->orderResource->load($order, $item['entity_id']);
                    if (!empty($order) && $order->getShipmentsCollection()->getSize() > 0) {
                        foreach ($order->getShipmentsCollection() as $shipment) {
                            if (!empty($shipment->getShippingLabel())) {
                                $item[$this->getData('name')][$shipment->getId()] =
                                     [
                                        'href' => $shipment->getShippingLabel(),
                                        'target' => '_blank',
                                        'label' => __('Print') . ' ' . array_first($shipment->getTracks())->getTRackNumber()
                                    ];

                            }
                        }
                    }
                }
            }
        }

        return $dataSource;
    }
}
