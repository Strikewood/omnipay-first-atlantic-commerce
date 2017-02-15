<?php
namespace tests;


use Omnipay\FirstAtlanticCommerce\Gateway;
use Omnipay\Tests\GatewayTestCase;

class TransactionModificationTest extends GatewayTestCase
{
    /** @var  Gateway */
    protected $gateway;

    private $options;

    public function setUp()
    {
        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
        $this->gateway->setMerchantId('123');
        $this->gateway->setMerchantPassword('abc1233');

        $this->options = [
            'amount' => '10.00',
            'currency' => 'USD',
            'transactionId' => '1234'
        ];
    }

    public function testSuccessfulCapture()
    {
        $this->setMockHttpResponse('ModificationSuccess.txt');

        $response = $this->gateway->capture($this->options)->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(1101, $response->getCode());
        $this->assertEquals('Success', $response->getMessage());
    }

    public function testFailedCapture()
    {
        $this->setMockHttpResponse('ModificationFailed.txt');

        $response = $this->gateway->capture($this->options)->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertEquals(1100, $response->getCode());
        $this->assertEquals('Failed', $response->getMessage());
    }

    public function testSuccessfulRefund()
    {
        $this->setMockHttpResponse('ModificationSuccess.txt');

        $response = $this->gateway->refund($this->options)->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(1101, $response->getCode());
        $this->assertEquals('Success', $response->getMessage());
    }

    public function testFailedRefund()
    {
        $this->setMockHttpResponse('ModificationFailed.txt');

        $response = $this->gateway->refund($this->options)->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertEquals(1100, $response->getCode());
        $this->assertEquals('Failed', $response->getMessage());
    }

    public function testSuccessfulVoid()
    {
        $this->setMockHttpResponse('ModificationSuccess.txt');

        $response = $this->gateway->void($this->options)->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(1101, $response->getCode());
        $this->assertEquals('Success', $response->getMessage());
    }

    public function testFailedVoid()
    {
        $this->setMockHttpResponse('ModificationFailed.txt');

        $response = $this->gateway->void($this->options)->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertEquals(1100, $response->getCode());
        $this->assertEquals('Failed', $response->getMessage());
    }
}