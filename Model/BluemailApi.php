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
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\Webapi\Rest\Request;
use Mantik\Bluemail\Helper\Config;
use Mantik\Bluemail\Helper\Debug;

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
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @var Debug
     */
    protected $debug;

    protected $messageManager;

    /**
     * BluemailApi constructor.
     * @param ClientFactory $clientFactory
     * @param ResponseFactory $responseFactory
     * @param Config $configHelper
     * @param \Psr\Log\LoggerInterface $logger
     * @param ManagerInterface $messageManager
     * @param Debug $debug
     */
    public function __construct(
        ClientFactory $clientFactory,
        ResponseFactory $responseFactory,
        Config $configHelper,
        \Psr\Log\LoggerInterface $logger,
        ManagerInterface $messageManager,
        Debug $debug
    ) {
        $this->clientFactory = $clientFactory;
        $this->responseFactory = $responseFactory;
        $this->configHelper = $configHelper;
        $this->logger = $logger;
        $this->debug = $debug;
        $this->messageManager = $messageManager;

        $this->headers = [];
        $this->bodyParam = [];
    }

    abstract public function execute($data);

    public function cleanData()
    {
        $this->headers = [];
        $this->bodyParam = [];
    }

    /**
     * Do API request with provided params
     *
     * @param string $uriEndpoint
     * @param string $requestMethod
     * @param bool   $includeClientId
     *
     * @return Response
     */
    protected function doRequest(
        string $uriEndpoint,
        string $requestMethod = Request::HTTP_METHOD_GET,
        bool $includeClientId = true
    ): Response {
        $params = [
            'headers' => $this->getHeaders()
        ];
        if ($requestMethod==Request::HTTP_METHOD_GET) {
            $params['query'] =   $this->getQueryParams($includeClientId);
        } else {
            $params['body'] =   json_encode($this->getQueryParams($includeClientId));
        }
        /** @var Client $client */
        $client = $this->clientFactory->create(
            [
                'config' => [ 'base_uri' => $this->configHelper->getApiUrl() ]
            ]
        );
        $this->debug->log($params, 'request');

        try {
            $response = $client->request(
                $requestMethod,
                $uriEndpoint,
                $params
            );
            $this->setStatus($response->getStatusCode());
            $responseBody = $response->getBody();
            $this->response = $responseBody->getContents();
            $this->debug->log($this->response, 'response');
        } catch (GuzzleException $exception) {
            /** @var Response $response */
            $response = $this->responseFactory->create([
                'status' => $exception->getCode(),
                'reason' => $exception->getMessage()
            ]);
            $this->logger->error($exception->getMessage());
            $this->debug->log($exception->getMessage(), 'error');
            $this->messageManager->addErrorMessage($exception->getMessage());

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

    protected function getQueryParams(bool $includeClientId)
    {
        $bodyParams = $this->bodyParam;
        if ($includeClientId) {
            $bodyParams = array_merge(['customerId' => $this->configHelper->getCustomerId()], $bodyParams);
        }
        return $bodyParams;
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
