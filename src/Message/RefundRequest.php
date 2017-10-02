<?php

namespace Omnipay\Vegaah\Message;

/**
 * Vegaah refund request
 *
 * {@inheritDoc}
 */
class RefundRequest extends CaptureRequest
{
    /**
     * Refund code for Vegaah
     *
     * @var int
     */
    protected $actionCode = 2;

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
