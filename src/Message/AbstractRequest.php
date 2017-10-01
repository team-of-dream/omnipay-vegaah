<?php

namespace Omnipay\Vegaah\Message;

use Omnipay\Common\Message\AbstractRequest as OmnipayAbstractRequest;
use SimpleXMLElement;
use Symfony\Component\EventDispatcher\Event;

/**
 * Abstract Request
 *
 * This class implements RequestInterface and defines a basic
 * set of functions for a Vegaah Omnipay Request.
 *
 * @see          RequestInterface
 * @see          AbstractResponse
 */
abstract class AbstractRequest extends OmnipayAbstractRequest
{
    /**
     * Test Vehaah endpoint URL
     *
     * @var string
     */
    protected $testEndpoint = 'https://secure.soft-connect.biz/DirectTransaction.aspx';

    /**
     * Live Vegaah endpoint URL
     *
     * @var string
     */
    protected $liveEndpoint = 'https://secure.soft-connect.biz/DirectTransaction.aspx';

    /**
     * Get Vegaah URL
     *
     * @return string
     */
    protected function getEndpoint()
    {
        return $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }

    /**
     * Get HTTP method for the Vegaah endpoint
     *
     * @return string
     */
    protected function getHttpMethod()
    {
        return 'POST';
    }

    /**
     * Returns terminal id
     *
     * @return int
     */
    public function getTerminalId()
    {
        return $this->getParameter('terminalid');
    }

    /**
     * Set terminal id
     *
     * @param int $value
     *
     * @return $this
     */
    public function setTerminalId($value)
    {
        return $this->setParameter('terminalid', $value);
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->getParameter('password');
    }

    /**
     * Set password
     *
     * @param string $value
     *
     * @return $this
     */
    public function setPassword($value)
    {
        return $this->setParameter('password', $value);
    }

    /**
     * Get action code
     *
     * 1 - purchase
     * 2 - refund/credit
     * 4 — pre-authorization
     * 5 — capture
     * 9 — void pre-authorization
     *
     * @return int
     */
    public function getAction()
    {
        return $this->getParameter('action');
    }

    /**
     * Set action code
     *
     * 1 - purchase
     * 2 - refund/credit
     * 4 — pre-authorization
     * 5 — capture
     * 9 — void pre-authorization
     *
     * @param int $value
     *
     * @return $this
     */
    public function setAction($value)
    {
        return $this->setParameter('action', $value);
    }

    /**
     * Get the id you (the merchant) provided to represent this transaction
     *
     * @return string
     */
    public function getTrackId()
    {
        return $this->getParameter('trackid');
    }

    /**
     * Set the id you (the merchant) provided to represent this transaction
     *
     * @param string $value
     *
     * @return $this
     */
    public function setTrackId($value)
    {
        return $this->setParameter('trackid', $value);
    }

    /**
     * Get country code
     *
     * @return string
     */
    public function getCountryCode()
    {
        return $this->getParameter('CountryCode');
    }

    /**
     * Set country code
     *
     * @param string $value
     *
     * @return $this
     */
    public function setCountryCode($value)
    {
        return $this->setParameter('CountryCode', $value);
    }

    /**
     * Get state code (full name of the state)
     *
     * @return string
     */
    public function getStateCode()
    {
        return $this->getParameter('statecode');
    }

    /**
     * Set state code (full name of the state)
     *
     * @param string $value
     *
     * @return $this
     */
    public function setStateCode($value)
    {
        return $this->setParameter('statecode', $value);
    }

    /**
     * Get zip code
     *
     * @return int
     */
    public function getZip()
    {
        return $this->getParameter('zip');
    }

    /**
     * Set zip code
     *
     * @param int $value
     *
     * @return $this
     */
    public function setZip($value)
    {
        return $this->setParameter('zip', $value);
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->getParameter('address');
    }

    /**
     * Get address
     *
     * @param $value
     *
     * @return $this
     */
    public function setAddress($value)
    {
        return $this->setParameter('address', $value);
    }

    /**
     * Get original transaction reference number provided by gateway
     *
     * @return mixed
     */
    public function getTransId()
    {
        return $this->getParameter('transid');
    }

    /**
     * Get original transaction reference number provided by gateway
     *
     * @param $value
     *
     * @return $this
     */
    public function setTransID($value)
    {
        return $this->setParameter('transid', $value);
    }

    /**
     * @param array $data
     *
     * {@inheritDoc}
     */
    public function sendData($data)
    {
        $this->httpClient->getEventDispatcher()->addListener(
            'request.error',
            function (Event $event) {
                if ($event['response']->isClientError()) {
                    $event->stopPropagation();
                }
            }
        );

        $xmlData = $this->arrayToXml($data);

        $httpRequest = $this->httpClient->createRequest(
            $this->getHttpMethod(),
            $this->getEndpoint(),
            ['content-type' => 'text/xml;charset=utf-8'],
            $xmlData
        );

        try {
            $httpRequest->getCurlOptions()->set(CURLOPT_SSLVERSION, 6);
            $httpResponse = $httpRequest->send();

            $body = $httpResponse->getBody(true);

            $xmlToArrayResponse = !empty($body) ? $httpResponse->xml() : [];

            return $this->response = $this->createResponse($xmlToArrayResponse, $httpResponse->getStatusCode());
        } catch (\Exception $e) {
            throw new \Exception(
                "Error communicating with payment gateway: {$e->getMessage()}",
                $e->getCode()
            );
        }
    }

    /**
     * Create a Vegaah Omnipay responce instance
     *
     * @param SimpleXMLElement $data
     * @param int              $statusCode
     *
     * @return \Omnipay\Vegaah\Message\Response
     */
    protected function createResponse(SimpleXMLElement $data, $statusCode)
    {
        return $this->response = new Response($this, $data, $statusCode);
    }

    /**
     * Converts a given array to XML
     *
     * @param array $data
     *
     * @return string
     */
    private function arrayToXml(array $data)
    {
        $xml = new SimpleXMLElement('<request/>');

        array_walk_recursive($data, function ($value, $key) use ($xml) {
            $xml->addChild($key, $value);
        });

        return $xml->asXML();
    }
}
