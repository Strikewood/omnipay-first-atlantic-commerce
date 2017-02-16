<?php

namespace tests;


use Omnipay\FirstAtlanticCommerce\Gateway;
use Omnipay\Tests\GatewayTestCase;

class StatusTest extends GatewayTestCase
{
    /** @var  Gateway */
    protected $gateway;
    /** @var  array */
    private $statusOptions;

    public function setUp()
    {
        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());

        $this->gateway->setMerchantId('123');
        $this->gateway->setMerchantPassword('abc123');

        $this->statusOptions = [
            'transactionId' => '1234'
        ];
    }

    public function testSuccessfulStatus()
    {
        $this->setMockHttpResponse('StatusSuccess.txt');

        $response = $this->gateway->status($this->statusOptions)->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('Transaction is approved.', $response->getMessage());
        $this->assertEquals('1234', $response->getTransactionReference());
    }

    public function testFailedStatus()
    {
        $this->setMockHttpResponse('StatusFailure.txt');

        $response = $this->gateway->status($this->statusOptions)->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertEquals('No Response', $response->getMessage());
        $this->assertEquals('1234', $response->getTransactionReference());
    }
}