<?php

namespace Omnipay\Vegaah\Message;

/**
 * Vegaah purchase request
 *
 * {@inheritDoc}
 */
class PurchaseRequest extends AuthorizeRequest
{
    /**
     * Purchase code for Vegaah
     *
     * @var int
     */
    protected $actionCode = 1;

    /**
     * {@inheritDoc}
     */
    public function getData()
    {
        $data = parent::getData();

        $data['action'] = $this->actionCode;

        return $data;
    }
}
