<?php
namespace Omnipay\Constriv;

use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{
    private $gateway;
    
    public function setUp()
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
        $this->gateway->setMerchantId('1765');
        $this->gateway->setMerchantPassword('Y23X05ZS4tsA');
    }

    public function testAuthorize()
    {
        // Create a credit card object
        // This card can be used for testing.
        $card = new \Omnipay\Common\CreditCard([
            'email' => 'info@pippo.com'
        ]);        
        
        /* @var $authorize \Omnipay\Constriv\Message\AuthorizeRequest */
        $authorize = $this->gateway->authorize([
            'amount'        => '10.00',
            'currency'      => 'EUR',
            'transactionId' => '97383',
            'token'         => '9Z1q8o24q9m5VSVoQ0hPxHKK2hAVw8B0',
            'returnUrl'     => 'http://www.google.com',
            'cancelUrl'     => 'http://www.google.com',
            'card'          => $card
        ]);        
        
        $this->assertSame('10.00', $authorize->getAmount());
        $this->assertSame('EUR', $authorize->getCurrency());
        $this->assertSame('97383', $authorize->getTransactionId());
        $this->assertSame('9Z1q8o24q9m5VSVoQ0hPxHKK2hAVw8B0', $authorize->getToken());
    }

    public function testPayout()
    {
        $request = $this->gateway->payout(array(
            'clientAccountNumber' => '9912345678',
            'transactionId' => 'TX8889777',
            'amount' => '12.43',
            'currency' => 'EUR'
        ));

        $this->assertSame('9912345678', $request->getClientAccountNumber());
        $this->assertSame('TX8889777', $request->getTransactionId());
        $this->assertSame('12.43', $request->getAmount());
        $this->assertSame('EUR', $request->getCurrency());
    }

    public function testFetchTransaction()
    {
        $request = $this->gateway->fetchTransaction(array(
            'transactionId' => 'TX5557666',
            'transactionReference' => 'XXAACCD3231232'
        ));

        $this->assertSame('TX5557666', $request->getTransactionId());
        $this->assertSame('XXAACCD3231232', $request->getTransactionReference());
    }

}
