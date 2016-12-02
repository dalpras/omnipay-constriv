<?php

namespace Omnipay\Constriv\Message;

use Omnipay\Common\Message\AbstractRequest;

/**
 * Authorize and immediately capture an amount on the customer's card
 *
 * @author DalPraS
 */
class AuthorizeRequest extends AbstractRequest {
    
    const ACTION_PURCHASE = 1;
    
    const LANG_ITA = 'ITA';   
    
    /**
     * Live EndPoint
     *
     * @var string
     */ 
    private $liveEndpoint = 'https://ipg.constriv.com/IPGWeb/servlet/PaymentInitHTTPServlet';
    
    /**
     * Developer EndPoint
     *
     * @var string
     */    
//    protected $testEndpoint = 'https://ipg-test4.constriv.com/IPGWeb/servlet/PaymentInitHTTPServlet';    
    private $testEndpoint = 'http://localhost/it/it/pay/mockup/payment-init';    
    
    /**
     * @var bool
     */
    protected $zeroAmountAllowed = false;

    public function getId() {
        return $this->getParameter('id');
    }

    public function setId($value) {
        return $this->setParameter('id', $value);
    }

    public function getPassword() {
        return $this->getParameter('password');
    }

    public function setPassword($value) {
        return $this->setParameter('password', $value);
    }
    
    /**
     * Token che viene passato durante la transazione per garantire sicurezza in più.
     * 
     * @return string
     */
    public function getToken() {
        return $this->getParameter('token');
    }

    public function setToken($value) {
        return $this->setParameter('token', $value);
    }

    public function getData() {
        $this->validate('amount', 'currency', 'cancelUrl', 'returnUrl');
        
//        $data = [
//            'id'           => $config->pay->merchantId,
//            'password'     => $config->pay->merchantPassword,
//            'action'       => Order::ACTION_PURCHASE,
//            'amt'          => sprintf("%0.2F", $order->getAmount()),
//            'currencycode' => Order::CURRENCY_EURO,
//            'langid'       => Order::LANG_ITA,
//            'responseURL'  => $responseUrl,
//            'errorURL'     => $errorURL,
//            'trackid'      => $order->getId(),
//            'udf2'         => $order->getToken(),
//            'udf3'         => 'EMAILADDR:' . $order->getProfile()->getEmail(),
//            'udf5'         => 'HPP_TIMEOUT=20',
//        ];
        
        $data = [];
        $data['id'] = $this->getId();
        $data['password'] = $this->getPassword();
        $data['action'] = self::ACTION_PURCHASE;
        $data['amt'] = $this->getAmount();
        $data['currencycode'] = $this->getCurrencyNumeric();
        $data['responseURL'] = $this->getReturnUrl();
        $data['errorURL'] = $this->getCancelUrl();
        $data['langid'] = self::LANG_ITA;
        $data['trackid'] = $this->getTransactionId();
        $data['udf2'] = $this->getToken();
        if ($this->getCard()) {
            $data['udf3'] = 'EMAILADDR:' . $this->getCard()->getEmail();
        } 
        $data['udf5'] = 'HPP_TIMEOUT=20';
        
        return $data;
    }
    
    public function sendData($data) {
        $httpRequest = $this->httpClient->post($this->getEndpoint(), null, http_build_query($data, '', '&'));
        $httpRequest->getCurlOptions()->set(CURLOPT_SSLVERSION, 6); // CURL_SSLVERSION_TLSv1_2 for libcurl < 7.35
        $httpResponse = $httpRequest->send();
        return $this->createResponse($httpResponse->getBody());
    }

    private function createResponse($data) {
        return $this->response = new AuthorizeResponse($this, $data);
    }

    public function getEndpoint() {
        return $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }

}
