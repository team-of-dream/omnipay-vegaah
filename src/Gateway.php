<?php

namespace Omnipay\Vegaah;

use Omnipay\Common\AbstractGateway;

/**
 * {@inheritDoc}
 */
class Gateway extends AbstractGateway
{
    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'Vegaah';
    }

    /**
     * {@inheritDoc}
     */
    public function getDefaultParameters()
    {
        return [
            'terminalid'   => '',
            'password'     => '',
            'action'       => '',
            'currencyCode' => '',
            'email'        => '',
            'amount'       => '',
            'trackid'      => '',
        ];
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
     * Vegaah pre-authorization aciton
     *
     * {@inheritdoc}
     */
    public function authorize(array $options = [])
    {
        return $this->createRequest(Message\AuthorizeRequest::class, $options);
    }
}
