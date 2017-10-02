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
     * Test Vegaah endpoint URL
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
     * Set address
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
     * Get IP address of the merchant’s system from which
     * transaction is generated
     *
     * @return string
     */
    public function getMerchantIp()
    {
        return $this->getParameter('merchantip');
    }

    /**
     * Set IP address of the merchant’s system
     *
     * @param $value
     *
     * @return $this
     */
    public function setMerchantIp($value)
    {
        return $this->setParameter('merchantip', $value);
    }

    /**
     * Get IP address of the customer’s system
     *
     * @return string
     */
    public function getCustomerIp()
    {
        return $this->getParameter('customerip');
    }

    /**
     * Set IP address of the customer’s system
     *
     * @param $value
     *
     * @return $this
     */
    public function setCustomerIp($value)
    {
        return $this->setParameter('customerip', $value);
    }

    /**
     * Get User defined field1.
     *
     * @return string
     */
    public function getUdf1()
    {
        return $this->getParameter('udf1');
    }

    /**
     * Set User defined field1
     *
     * @param $value
     *
     * @return $this
     */
    public function setUdf1($value)
    {
        return $this->setParameter('udf1', $value);
    }

    /**
     * Get User defined field2.
     *
     * @return string
     */
    public function getUdf2()
    {
        return $this->getParameter('udf2');
    }

    /**
     * Set User defined field2
     *
     * @param $value
     *
     * @return $this
     */
    public function setUdf2($value)
    {
        return $this->setParameter('udf2', $value);
    }

    /**
     * Get User defined field3.
     *
     * @return string
     */
    public function getUdf3()
    {
        return $this->getParameter('udf3');
    }

    /**
     * Set User defined field3
     *
     * @param $value
     *
     * @return $this
     */
    public function setUdf3($value)
    {
        return $this->setParameter('udf3', $value);
    }

    /**
     * Get User defined field4.
     *
     * @return string
     */
    public function getUdf4()
    {
        return $this->getParameter('udf4');
    }

    /**
     * Set User defined field4
     *
     * @param $value
     *
     * @return $this
     */
    public function setUdf4($value)
    {
        return $this->setParameter('udf4', $value);
    }

    /**
     * Get User defined fields, merchantIp and customerIp fields data.
     *
     * @return array
     */
    public function getUdfAndIpFields()
    {
        return [
            'merchatip'  => $this->getMerchantIp(),
            'customerip' => $this->getCustomerIp(),
            'udf1'       => $this->getUdf1(),
            'udf2'       => $this->getUdf2(),
            'udf3'       => $this->getUdf3(),
            'udf4'       => $this->getUdf4(),
        ];
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

            $xmlToArrayResponse = !empty($body) ? (array)$httpResponse->xml() : [];

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
     * @param array $data
     * @param int   $statusCode
     *
     * @return \Omnipay\Vegaah\Message\Response
     */
    protected function createResponse(array $data, $statusCode)
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
