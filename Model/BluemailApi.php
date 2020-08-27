<?php
/**
 * Copyright ©  2020. Mantik Tech.  All rights reserved under CC BY-NC-SA 4.0 licence.
 * See LICENSE file for more details.
 * @link https://www.mantik.tech/
 */

namespace Mantik\Bluemail\Model;

use GuzzleHttp\Client;
use GuzzleHttp\ClientFactory;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ResponseFactory;
use Magento\Framework\Webapi\Rest\Request;
use Mantik\Bluemail\Helper\Config;

/**
 * @api
 * @since 100.0.2
 */
class BluemailApi {

    const HEADER_APPLICATION_JSON = 'application/json';

    /**
     * @var ResponseFactory
     */
    private $responseFactory;

    /**
     * @var ClientFactory
     */
    private $clientFactory;

    /**
     * @var Config
     */
    protected $configHelper;

    /**
     * GitApiService constructor
     *
     * @param ClientFactory $clientFactory
     * @param ResponseFactory $responseFactory
     * @param Config $configHelper
     */
    public function __construct(
        ClientFactory $clientFactory,
        ResponseFactory $responseFactory,
        Config $configHelper
    ) {
        $this->clientFactory = $clientFactory;
        $this->responseFactory = $responseFactory;
        $this->configHelper = $configHelper;
    }

    /**
     * Do API request with provided params
     *
     * @param string $uriEndpoint
     * @param array $params
     * @param string $requestMethod
     *
     * @return Response
     */
    protected function doRequest(
        string $uriEndpoint,
        array $params = [],
        string $requestMethod = Request::HTTP_METHOD_GET
    ): Response {
        /** @var Client $client */
        $client = $this->clientFactory->create(
            [
                'config' => [ 'base_uri' => $this->configHelper->getApiUrl() ]
            ]
        );

        try {
            $response = $client->request(
                $requestMethod,
                $uriEndpoint,
                $params
            );
        } catch (GuzzleException $exception) {
            /** @var Response $response */
            $response = $this->responseFactory->create([
                'status' => $exception->getCode(),
                'reason' => $exception->getMessage()
            ]);
        }

        return $response;
    }

    protected function getHeaders() {
        return [
            'Accept' => self::HEADER_APPLICATION_JSON,
            'Content-Type' => self::HEADER_APPLICATION_JSON,
            'X-Midla-App-Token' => $this->configHelper->getAppToken()
        ];
    }

    protected function getQueryParams() {
        return [
            'customerId' => $this->configHelper->getCustomerId()
        ];
    }
}
