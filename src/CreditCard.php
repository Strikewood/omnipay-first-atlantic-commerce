<?php

namespace Omnipay\FirstAtlanticCommerce;

use Omnipay\Common\CreditCard as BaseCreditCard;
use Omnipay\Common\Exception\InvalidCreditCardException;

class CreditCard extends BaseCreditCard
{
    /**
     * Validate this credit card. If the card is invalid, InvalidCreditCardException is thrown.
     *
     * This method is called internally by gateways to avoid wasting time with an API call
     * when the credit card is clearly invalid.
     *
     * Falls back to validating number, cvv, expiryMonth, expiryYear if no parameters are present.
     *
     * @param string ... Optional variable length list of required parameters
     * @throws InvalidCreditCardException
     */
    public function validate()
    {
        $parameters = func_get_args();

        if ( count($parameters) == 0 )
        {
            $parameters = ['number', 'expiryMonth', 'expiryYear'];
        }

        foreach ($parameters as $key)
        {
            $value = $this->parameters->get($key);

            if ( empty($value) )
            {
                throw new InvalidCreditCardException("The $key parameter is required");
            }
        }

        if ( isset($parameters['expiryMonth']) && isset($parameters['expiryYear']) )
        {
            if ( $this->getExpiryDate('Ym') < gmdate('Ym') )
            {
                throw new InvalidCreditCardException('Card has expired');
            }
        }

        if ( isset($parameters['number']) )
        {
            if ( !Helper::validateLuhn( $this->getNumber() ) )
            {
                throw new InvalidCreditCardException('Card number is invalid');
            }

            if ( !is_null( $this->getNumber() ) && !preg_match( '/^\d{12,19}$/i', $this->getNumber() ) )
            {
                throw new InvalidCreditCardException('Card number should have 12 to 19 digits');
            }
        }

    }
}
