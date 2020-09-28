<?php
/**
 * Copyright ©  2020. Mantik Tech.  All rights reserved under CC BY-NC-SA 4.0 licence.
 * See LICENSE file for more details.
 * @link https://www.mantik.tech/
 */

namespace Mantik\Bluemail\Model\BluemailApi;

use Mantik\Bluemail\Model\BluemailApi;
use Magento\Framework\Webapi\Rest\Request;

/**
 * Class Department
 * @package Mantik\Bluemail\Model\BluemailApi
 */
class Department extends BluemailApi
{
    /**
     * Endpoint
     */
    const API_REQUEST_ENDPOINT = 'localization/department';

    /**
     * Fetch some data from API
     *
     * @param $data
     */
    public function execute($data)
    {
        $this->setBodyParams($data);
        $this->doRequest(
            static::API_REQUEST_ENDPOINT,
            Request::HTTP_METHOD_GET,
            false
        );
    }

    public function getDepartements($countryId = 23) //TODO 23 is Argentina, maybe make it a config?
    {
        $this->execute([
            'countryId' => $countryId
        ]);

        return $this->getResponse();
    }
}
