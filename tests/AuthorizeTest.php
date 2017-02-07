<?php

namespace tests;


use Omnipay\FirstAtlanticCommerce\Gateway;
use Omnipay\Tests\GatewayTestCase;

class AuthorizeTest extends GatewayTestCase
{

    /** @var  Gateway */
    protected $gateway;

    /**
     * Setup the gateway to be used for testing.
     */
    public function setUp()
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
        $this->gateway->setMerchantId('123');
        $this->gateway->setMerchantPassword('abc123');
    }

    /**
     * Test the country formatting functionality
     */
    public function testFormatCountry()
    {
        //Alpha2
        $card = $this->getValidCard();
        $requestData = $this->getRequestData($card);
        $this->assertEquals(840, $requestData['BillingDetails']['BillToCountry']);

        //number
        $card['billingCountry'] = 840;
        $requestData = $this->getRequestData($card);
        $this->assertEquals(840, $requestData['BillingDetails']['BillToCountry']);

        //Alpha3
        $card['billingCountry'] = 'USA';
        $requestData = $this->getRequestData($card);
        $this->assertEquals(840, $requestData['BillingDetails']['BillToCountry']);
    }

    /**
     * @param $card
     *
     * @return array
     */
    private function getRequestData($card)
    {
        $request = $this->gateway->authorize([
            'amount' => '10.00',
            'currency' => 'USD',
            'transactionId' => uniqid(),
            'card' => $card
        ]);
        $requestData = $request->getData();
        return $requestData;
    }

}