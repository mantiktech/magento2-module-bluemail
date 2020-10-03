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
 * Class BluemailApi
 */
abstract class BluemailApi
{
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
     * @var Config
     */
    protected $helper;

    /**
     * @var array
     */
    protected $headers;

    /**
     * @var array
     */
    protected $bodyParam;

    /**
     * @var array
     */
    protected $response;

    /**
     * @var string
     */
    protected $status;
    /**
     * BluemailApi constructor.
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
        $this->headers = [];
        $this->bodyParam = [];
    }

    abstract public function execute($data);

    /**
     * Do API request with provided params
     *
     * @param string $uriEndpoint
     * @param string $requestMethod
     *
     * @return Response
     */
    protected function doRequest(
        string $uriEndpoint,
        string $requestMethod = Request::HTTP_METHOD_GET
    ): Response {
        $params = [

            'headers' => $this->getHeaders(),
            'query' => $this->getQueryParams()
        ];

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
            $this->setStatus($response->getStatusCode());
            $responseBody = $response->getBody();
            $this->response = $responseBody->getContents();
        } catch (GuzzleException $exception) {
            /** @var Response $response */
            $response = $this->responseFactory->create([
                'status' => $exception->getCode(),
                'reason' => $exception->getMessage()
            ]);
        }

        return $response;
    }

    protected function getHeaders()
    {
        return array_merge([
            'Accept' => self::HEADER_APPLICATION_JSON,
            'Content-Type' => self::HEADER_APPLICATION_JSON,
            'X-Midla-App-Token' => $this->configHelper->getAppToken()
        ], $this->headers);
    }

    protected function getQueryParams()
    {
        return array_merge(['customerId' => $this->configHelper->getCustomerId()], $this->bodyParam);
    }

    public function setHeaderParams($param)
    {
        if (is_array($param)) {
            $this->headers = array_merge($this->headers, $param);
        } else {
            $this->headers[] = $param;
        }
    }

    public function setBodyParams($param)
    {
        $this->bodyParam = array_merge_recursive($this->bodyParam, $param);
    }

    protected function setStatus($status)
    {
        $this->status = $status;
        //todo: if not 200 log response
    }

    protected function getStatus()
    {
        return $this->status;
    }

    public function getResponse()
    {
        return json_decode($this->response, true);
    }

}
