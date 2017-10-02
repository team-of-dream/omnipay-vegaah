<?php

namespace Omnipay\Vegaah\Message;

/**
 * Vegaah pre-authorization request
 *
 * {@inheritDoc}
 */
class AuthorizeRequest extends AbstractRequest
{
    /**
     * Authorize code for Vegaah
     *
     * @var int
     */
    protected $actionCode = 4;

    /**
     * {@inheritDoc}
     */
    public function getData()
    {
        $this->validate('amount', 'currency', 'terminalid', 'password', 'trackid');

        $data = [
            'terminalid'   => $this->getTerminalId(),
            'password'     => $this->getPassword(),
            'action'       => $this->actionCode,
            'amount'       => $this->getAmount(),
            'currencyCode' => $this->getCurrency(),
            'trackid'      => $this->getTrackId(),
            'CountryCode'  => $this->getCountryCode(),
            'statecode'    => $this->getStateCode(),
            'zip'          => $this->getZip(),
            'address'      => $this->getAddress(),
        ];

        if ($this->getCard()) {
            $data = array_merge($data, $this->getCardData());
        }

        //attach Udf fields,customer and merchant ip
        $data = array_merge($data, $this->getUdfAndIpFields());

        return $data;
    }

    /**
     * Get data for a card
     *
     * @return array
     */
    protected function getCardData()
    {
        $this->getCard()->validate();

        return [
            'card'     => $this->getCard()->getNumber(),
            'cvv2'     => $this->getCard()->getCvv(),
            'expYear'  => $this->getCard()->getExpiryDate('Y'),
            'expMonth' => $this->getCard()->getExpiryDate('m'),
            'member'   => $this->getCard()->getName(),
            'city'     => $this->getCard()->getCity(),
            'email'    => $this->getCard()->getEmail(),
        ];
    }
}
