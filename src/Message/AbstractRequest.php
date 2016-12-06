<?php

namespace Omnipay\Constriv\Message;

/**
 * Description of AbstractRequest
 *
 * @author DalPraS
 */
abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest {

    /**
     * Constriv purchase Action
     */
    const ACTION_PURCHASE = 1;
    
    /**
     * Constriv endpoint gateway language
     */
    const LANG_ITA = 'ITA';
    
    /**
     * Live EndPoint
     *
     * @var string
     */ 
    protected $liveEndpoint = 'https://ipg.constriv.com/IPGWeb/servlet/PaymentInitHTTPServlet';
    
    /**
     * Developer EndPoint
     *
     * @var string
     */    
//    protected $testEndpoint = 'https://ipg-test4.constriv.com/IPGWeb/servlet/PaymentInitHTTPServlet';    
    protected $testEndpoint = 'http://localhost/it/it/pay/mockup/payment-init';    

    /**
     * Get the Merchant ID
     *
     * This is the merchant number 
     * 
     * @return string merchant id
     */
    public function getMerchantId()
    {
        return $this->getParameter('merchantId');
    }

    /**
     * Set the Merchant ID
     *
     * This is the merchant number 
     *
     * @param  string $value merchant id
     * @return self
     */
    public function setMerchantId($value)
    {
        return $this->setParameter('merchantId', $value);
    }

    /**
     * Get the Merchant Password
     *
     * Password provided by Constriv.
     *
     * @return string merchant password
     */
    public function getMerchantPassword()
    {
        return $this->getParameter('merchantPassword');
    }

    /**
     * Set the Merchant Password
     *
     * Password provided by Constriv.
     *
     * @param  string $value merchant password
     * @return self
     */
    public function setMerchantPassword($value)
    {
        return $this->setParameter('merchantPassword', $value);
    }

    /**
     * Get the transaction Token.
     * 
     * @return string
     */
    public function getToken() {
        return $this->getParameter('token');
    }

    /**
     * Set the transaction Token.
     * 
     * @return string
     */
    public function setToken($value) {
        return $this->setParameter('token', $value);
    }    
    
    
}
