<?php
/**
 * Copyright ©  2020. Mantik Tech.  All rights reserved under CC BY-NC-SA 4.0 licence.
 * See LICENSE file for more details.
 * @link https://www.mantik.tech/
 */

namespace Mantik\Bluemail\Model\BluemailApi;

use Mantik\Bluemail\Model\BluemailApi;

/**
 * Class Shipments
 */
class Shipments extends BluemailApi {
    const API_REQUEST_ENDPOINT = 'delivery';

    /**
     * Fetch some data from API
     */
    public function execute(): void
    {
        $params = [
            'headers' => $this->getHeaders(),
            'query' => $this->getQueryParams()
        ];

        $response = $this->doRequest(
            static::API_REQUEST_ENDPOINT,
            $params
        );

        $status = $response->getStatusCode(); // 200 status code
        $responseBody = $response->getBody();
        $responseContent = $responseBody->getContents();
    }
}

