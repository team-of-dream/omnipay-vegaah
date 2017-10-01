<?php

namespace Omnipay\Vegaah\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\Common\Message\RedirectResponseInterface;

/**
 * {@inheritDoc}
 */
class Response extends AbstractResponse implements RedirectResponseInterface
{
    /**
     * HTTP responce status code
     *
     * @var int
     */
    protected $statusCode;

    /**
     * @param \Omnipay\Common\Message\RequestInterface $request
     * @param mixed                                    $data
     * @param int                                      $statusCode
     */
    public function __construct(RequestInterface $request, $data, $statusCode = 200)
    {
        parent::__construct($request, $data);

        $this->statusCode = $statusCode;
    }

    /**
     * Is the response successful?
     *
     * @return boolean
     * @throws \Omnipay\Common\Exception\InvalidResponseException
     */
    public function isSuccessful()
    {
        return !$this->isRedirect() && !$this->isPending()
            && $this->getCode() < 400 && $this->getResponseCode() == '000';
    }

    /**
     * Does the response require a redirect?
     *
     * @return boolean
     */
    public function isRedirect()
    {
        return isset($this->data['targetUrl']);
    }

    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isPending()
    {
        return isset($this->data['responsecode']) && $this->data['responsecode'] == '001';
    }

    /**
     * Get the reference provided by the gateway to represent this transaction
     *
     * @return string|null
     */
    public function getTransactionReference()
    {
        return isset($this->data['tranid']) ? $this->data['tranid'] : null;
    }

    /**
     * Get the id you (the merchant) provided to represent this transaction
     *
     * @return string|null
     */
    public function getTransactionId()
    {
        return isset($this->data['trackid']) ? $this->data['trackid'] : null;
    }

    /**
     * Gets the redirect target url. Returns null if url is not present in response.
     *
     * @return string|null
     */
    public function getRedirectUrl()
    {
        return $this->isRedirect() ? $this->data['targetUrl'] . $this->data['payid']  : null;
    }

    /**
     * Redirect method for responce
     *
     * @return string
     */
    public function getRedirectMethod()
    {
        return 'POST';
    }

    /**
     * Gets all data of response as array. Return null if response is not a redirect.
     *
     * @return array|null
     */
    public function getRedirectData()
    {
        if (!$this->isRedirect()) {
            return null;
        }

        return (array)$this->data;
    }

    /**
     * HTTP response code
     *
     * @return null|string
     */
    public function getCode()
    {
        return $this->statusCode;
    }

    /**
     * Response code
     *
     * @return null|string A response code from the payment gateway
     */
    public function getResponseCode()
    {
        return $this->data['responsecode'];
    }
}
