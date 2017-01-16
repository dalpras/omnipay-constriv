<?php

namespace Omnipay\Constriv;

use Omnipay\Common\AbstractGateway;

class Gateway extends AbstractGateway {

    public function getName() {
        return 'Constriv';
    }

    public function getDefaultParameters() {
        return [
            'merchantId'       => '',
            'merchantPassword' => '',
            'testMode'         => false,
        ];
    }

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
     * Create a purchase request.
     *
     * @param array $parameters
     * 
     * @return \Omnipay\Constriv\Message\PurchaseRequest
     */
    public function purchase(array $parameters = array()) {
        return $this->createRequest('\Omnipay\Constriv\Message\PurchaseRequest', $parameters);
    }

    /**
     * Handle return from off-site gateways after purchase
     * 
     * @param  array $parameters
     * @return \Omnipay\Constriv\Message\CompletePurchaseRequest
     */
    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Constriv\Message\CompletePurchaseRequest', $parameters);
    }
    

}
