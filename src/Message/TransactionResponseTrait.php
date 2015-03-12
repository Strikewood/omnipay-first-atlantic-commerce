<?php

namespace Omnipay\FirstAtlanticCommerce\Message;

trait TransactionResponseTrait
{
    /**
     * Return whether or not the response was successful
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        return isset($this->data['CreditCardTransactionResults']['ResponseCode']) and '1' === $this->data['CreditCardTransactionResults']['ResponseCode'];
    }

    /**
     * Return the response's reason code
     *
     * @return string
     */
    public function getCode()
    {
        return isset($this->data['CreditCardTransactionResults']['ReasonCode']) ? $this->data['CreditCardTransactionResults']['ReasonCode'] : null;
    }

    /**
     * Return the response's reason message
     *
     * @return string
     */
    public function getMessage()
    {
        return isset($this->data['CreditCardTransactionResults']['ReasonCodeDescription']) ? $this->data['CreditCardTransactionResults']['ReasonCodeDescription'] : null;
    }

    /**
     * Return transaction reference
     *
     * @return string
     */
    public function getTransactionReference()
    {
        return isset($this->data['CreditCardTransactionResults']['ReferenceNumber']) ? $this->data['CreditCardTransactionResults']['ReferenceNumber'] : null;
    }
}
