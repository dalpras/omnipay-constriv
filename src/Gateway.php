<?php

namespace Omnipay\Constriv;

use Omnipay\Common\AbstractGateway;

/**
 * Nexi payment gateway class
 *
 * This abstract class should be extended by all payment gateways
 * throughout the Omnipay system.  It enforces implementation of
 * the GatewayInterface interface and defines various common attibutes
 * and methods that all gateways should have.
 *
 * Example:
 *
 * <code>
 *   // Initialise the gateway
 *   $gateway->initialize(...);
 *
 *   // Get the gateway parameters.
 *   $parameters = $gateway->getParameters();
 *
 *   // Create a credit card object
 *   $card = new CreditCard(...);
 *
 *   // Do an authorisation transaction on the gateway
 *   if ($gateway->supportsAuthorize()) {
 *       $gateway->authorize(...);
 *   } else {
 *       throw new \Exception('Gateway does not support authorize()');
 *   }
 * </code>
 *
 * For further code examples see the *omnipay-example* repository on github.
 *
 */
class Gateway extends AbstractGateway {

    /**
     * Get gateway display name
     *
     * This can be used by carts to get the display name for each gateway.
     * @return string
     */
    public function getName() {
        return 'Constriv';
    }

    /**
     * Define gateway parameters, in the following format:
     *
     * array(
     *     'username' => '', // string variable
     *     'testMode' => false, // boolean variable
     *     'landingPage' => array('billing', 'login'), // enum variable, first item is default
     * );
     * @return array
     */
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
