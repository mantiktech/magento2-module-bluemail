<?php
/**
 * Copyright ©  2020. Mantik Tech.  All rights reserved under CC BY-NC-SA 4.0 licence.
 * See LICENSE file for more details.
 * @link https://www.mantik.tech/
 */

namespace Mantik\Bluemail\Model\BluemailApi;

use Magento\Framework\Webapi\Rest\Request;
use Mantik\Bluemail\Model\BluemailApi;
use Mantik\Bluemail\Helper\Config;
/**
 * Class Delivery
 */
class Delivery extends BluemailApi
{
    const API_REQUEST_ENDPOINT = 'delivery';
    /**
     * Fetch some data from API
     * @param $data
     */
    public function execute($data)
    {
        //todo: check $data paramas
        $param = ["shipment" => [
                   'fromType' => \Mantik\Bluemail\Helper\Config::API_REQUEST_FROM_TYPE,
                    'origenId' => \Mantik\Bluemail\Helper\Config::API_REQUEST_ORIGEN_ID,
                    'depositId' => $this->configHelper->getDepositId()
                 ]
            ];
        $this->setBodyParams($param);
        $this->setBodyParams($data);
        $this->doRequest(
            static::API_REQUEST_ENDPOINT,
            Request::HTTP_METHOD_GET
        );
    }
}
