<?php
/**
 * Copyright ©  2020. Mantik Tech.  All rights reserved under CC BY-NC-SA 4.0 licence.
 * See LICENSE file for more details.
 * @link https://www.mantik.tech/
 */

namespace Mantik\Bluemail\Model\BluemailApi;

use GuzzleHttp\ClientFactory;
use GuzzleHttp\Psr7\ResponseFactory;
use Mantik\Bluemail\Helper\Config;
use Mantik\Bluemail\Model\BluemailApi;

/**
 * Class Stores
 */
class Stores extends BluemailApi {
    const API_REQUEST_ENDPOINT = 'store';

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

    public function getDepositList(
        $customerId = null
    ) {
        if (!$customerId) {
            $customerId = $this->configHelper->getCustomerId();
        }

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

