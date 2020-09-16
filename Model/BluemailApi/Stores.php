<?php
/**
 * Copyright ©  2020. Mantik Tech.  All rights reserved under CC BY-NC-SA 4.0 licence.
 * See LICENSE file for more details.
 * @link https://www.mantik.tech/
 */

namespace Mantik\Bluemail\Model\BluemailApi;

use Mantik\Bluemail\Model\BluemailApi;

/**
 * Class Stores
 */
class Stores extends BluemailApi
{
    const API_REQUEST_ENDPOINT = 'store';

    /**
     * Fetch some data from API
     * @param array $data
     */
    public function execute($data=[])
    {
        $this->doRequest(
            static::API_REQUEST_ENDPOINT
        );
    }

    public function getDepositList()
    {
        $response = $this->doRequest(
            static::API_REQUEST_ENDPOINT
        );

        if ($this->getStatus() == 200) {

            return $this->getResponse();
        }

        return false;
    }
}
