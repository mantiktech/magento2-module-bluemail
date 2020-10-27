<?php
/**
 * Copyright ©  2020. Mantik Tech.  All rights reserved under CC BY-NC-SA 4.0 licence.
 * See LICENSE file for more details.
 * @link https://www.mantik.tech/
 */

namespace Mantik\Bluemail\Model\BluemailApi;

use Magento\Framework\Webapi\Rest\Request;
use Mantik\Bluemail\Model\BluemailApi;

/**
 * Class Estimates
 */
class Estimates extends BluemailApi
{
    const API_REQUEST_ENDPOINT = 'delivery/price';

    /**
     * Fetch some data from API
     * @param $data
     */
    public function execute($data)
    {
        //todo: check $data paramas
        $this->setBodyParams(['depositId' => $this->configHelper->getDepositId()]);
        $this->setBodyParams($data);
        $this->doRequest(
            static::API_REQUEST_ENDPOINT,
            Request::HTTP_METHOD_GET
        );
    }
}
