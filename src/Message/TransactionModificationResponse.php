<?php

namespace Omnipay\FirstAtlanticCommerce\Message;

use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\FirstAtlanticCommerce\Message\AbstractResponse;
use Omnipay\FirstAtlanticCommerce\Message\TransactionResponseTrait;

/**
 * FACPG2 Transaction Modification Response
 */
class TransactionModificationResponse extends AbstractResponse
{
    use TransactionResponseTrait;

    /**
     * Constructor
     *
     * @param RequestInterface $request
     * @param string $data
     */
    public function __construct(RequestInterface $request, $data)
    {
        if ( empty($data) ) {
            throw new InvalidResponseException();
        }

        $this->request = $request;
        $this->data    = $this->xmlDeserialize($data);
    }
}
