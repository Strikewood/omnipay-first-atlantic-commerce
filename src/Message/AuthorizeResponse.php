<?php

namespace Omnipay\FirstAtlanticCommerce\Message;

use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\FirstAtlanticCommerce\Message\AbstractResponse;
use Omnipay\FirstAtlanticCommerce\Message\TransactionResponseTrait;

/**
 * FACPG2 XML Authorize Response
 */
class AuthorizeResponse extends AbstractResponse
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
        if ( empty($data) )
        {
            throw new InvalidResponseException();
        }

        $this->request = $request;
        $this->data    = $this->xmlDeserialize($data);

        $this->verifySignature();
    }

    /**
     * Verifies the signature for the response.
     *
     * @throws InvalidResponseException if the signature doesn't match
     *
     * @return void
     */
    public function verifySignature()
    {
        if ( isset($this->data['CreditCardTransactionResults']['ResponseCode']) && (
            '1' == $this->data['CreditCardTransactionResults']['ResponseCode'] ||
            '2' == $this->data['CreditCardTransactionResults']['ResponseCode']) )
        {
            $signature  = $this->request->getMerchantPassword();
            $signature .= $this->request->getMerchantId();
            $signature .= $this->request->getAcquirerId();
            $signature .= $this->request->getTransactionId();

            $signature  = base64_encode( sha1($signature, true) );

            if ( $signature !== $this->data['Signature'] ) {
                throw new InvalidResponseException('Signature verification failed');
            }
        }
    }
}
