<?php

namespace tests;


use Omnipay\FirstAtlanticCommerce\Gateway;
use Omnipay\Tests\GatewayTestCase;

/**
 * Class IntegrationTest
 *
 * Integration tests will communicate with the First Atlantic commerce sandbox so you will need credentials for that
 * environment. You will then need to set those credentials in the myCredentials.json file in the tests folder. The
 * format of that json file is as follows:
 *
 * {
 *     "merchantId":"<your ID>",
 *     "merchantPassword":"<you password>"
 * }
 *
 * If myCredentials.json does not exists or the json is not complete, all tests in this class will be skipped.
 *
 * @package tests
 */
class IntegrationTest extends GatewayTestCase
{
    /** @var  Gateway */
    protected $gateway;

    /**
     * Checks to make sure that myCredentials.json exists and has the correct credentials configured. If they are, it sets
     * up the gateway instance. If they are not, it will skip the tests in this class.
     */
    public function setUp()
    {
        $merchantId = '';
        $merchantPassword = '';

        if(file_exists('myCredentials.json')) {
            $credentialsJson = file_get_contents('myCredentials.json');
            if($credentialsJson) {
                $credentials = json_decode($credentialsJson);
                $merchantId = $credentials->merchantId;
                $merchantPassword = $credentials->merchantPassword;
            }
        }

        if(empty($merchantId) || empty($merchantPassword)) {
            $this->markTestSkipped();
        } else {
            $this->gateway = new Gateway();
            $this->gateway->setMerchantId($merchantId);
            $this->gateway->setMerchantPassword($merchantPassword);
            $this->gateway->setTestMode(true);
            $this->gateway->setRequireAvsCheck(false);
        }
    }

    /**
     * Runs through an authorize, capture, and refund request to test that they are coming back from FAC as expected.
     */
    public function testAuthorizeCapture()
    {
        $transactionId = uniqid();
        $authResponse = $this->gateway->authorize([
            'amount'        => '15.00',
            'currency'      => 'USD',
            'transactionId' => $transactionId,
            'card'          => $this->getValidCard()
        ])->send();

        $this->assertTrue($authResponse->isSuccessful(), 'Authorize should succeed');

        $captureResponse = $this->gateway->capture([
            'amount'        => '15.00',
            'currency'      => 'USD',
            'transactionId' => $transactionId
        ])->send();

        $this->assertTrue($captureResponse->isSuccessful(), 'Capture should succeed');

        $refundResponse = $this->gateway->refund([
            'amount'        => '15.00',
            'currency'      => 'USD',
            'transactionId' => $transactionId
        ])->send();

        $this->assertTrue($refundResponse->isSuccessful(), 'Refund should succeed');
    }

    /**
     * Runs through a purchase, void, refund request to make sure that they are coming back from FAC as expected. FAC
     * seems to be auto settling captured transactions in their sandbox so the void request is going to come back as false.
     */
    public function testPurchaseVoidRefund()
    {
        $transactionId = uniqid();
        $purchaseResponse = $this->gateway->purchase([
            'amount' => '20.00',
            'currency' => 'USD',
            'transactionId' => $transactionId,
            'card' => $this->getValidCard()
        ])->send();

        $this->assertTrue($purchaseResponse->isSuccessful(), 'Purchase should succeed');

        $voidResponse = $this->gateway->void([
            'amount' => '20.00',
            'currency' => 'USD',
            'transactionId' => $transactionId
        ])->send();

        $this->assertFalse($voidResponse->isSuccessful(), 'Void should fail');

        $refundResponse = $this->gateway->refund([
            'amount' => '20.00',
            'currency' => 'USD',
            'transactionId' => $transactionId
        ])->send();

        $this->assertTrue($refundResponse->isSuccessful(), 'Purchase refund should succeed');
    }
}