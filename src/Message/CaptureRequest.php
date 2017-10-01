<?php

namespace Omnipay\Vegaah\Message;

/**
 * Vegaah capture request
 *
 * {@inheritDoc}
 */
class CaptureRequest extends AbstractRequest
{
    /**
     * Capture code for Vegaah
     *
     * @var int
     */
    protected $actionCode = 5;

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
     * {@inheritDoc}
     */
    public function getData()
    {
        $this->validate('terminalid', 'trackid', 'transid' ,'password','amount', 'currency');

        $data = [
            'terminalid'   => $this->getTerminalId(),
            'password'     => $this->getPassword(),
            'action'       => $this->actionCode,
            'amount'       => $this->getAmount(),
            'currencyCode' => $this->getCurrency(),
            'trackid'      => $this->getTrackId(),
            'transid'      => $this->getTransId(),
        ];

        //attach Udf fields,customer and merchant ip
        $data = array_merge($data, $this->getUdfAndIpFields());

        return $data;
    }

}