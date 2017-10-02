<?php

namespace Omnipay\Vegaah\Message;

/**
 * Vegaah Void request
 *
 * {@inheritDoc}
 */
class VoidRequest extends CaptureRequest
{
    /**
     * void code for Vegaah
     *
     * @var int
     */
    protected $actionCode = 9;

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
