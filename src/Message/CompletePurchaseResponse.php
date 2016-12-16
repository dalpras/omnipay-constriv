<?php

namespace Omnipay\Constriv\Message;

class CompletePurchaseResponse extends \Omnipay\Common\Message\AbstractResponse implements \Omnipay\Common\Message\RedirectResponseInterface {

    /**
     * Type of card used during payout.
     * 
     * @return string
     */
    public function getCardtype() {
        return $this->isSuccessful() ? $this->data['cardtype'] : null;
    }
    
    /**
     * Token setted during purchase initialization.
     * 
     * @return string
     */
    public function getToken() {
        return $this->isSuccessful() ? $this->data['token'] : null;
    }
    
    /**
     * Gateway Reference
     *
     * @return null|string A reference provided by the gateway to represent this transaction
     */
    public function getTransactionReference() {
        return $this->isSuccessful() ? $this->data['transactionReference'] : null;
    }

    /**
     * Get the transaction ID as generated by the merchant website.
     *
     * @return string
     */
    public function getTransactionId() {
        return $this->isSuccessful() ? $this->data['transactionId'] : null;
    }

    public function isSuccessful() {
        return isset($this->data['result']) && $this->data['result'] == 'CAPTURED';
    }

    /**
     * Does the response require a redirect?
     *
     * @return boolean
     */
    public function isRedirect() {
        return true;
    }    
    
    /**
     * Gets the redirect form data array, if the redirect method is POST.
     *
     * @return array
     */    
    public function getRedirectData() {
        return [];
    }

    /**
     * Get the required redirect method (either GET or POST).
     *
     * @return string
     */    
    public function getRedirectMethod() {
        return 'GET';
    }

    /**
     * Gets the redirect target url.
     *
     * @return string
     */    
    public function getRedirectUrl() { 
//        $query = http_build_query(['paymentId' => $this->data['paymentId']], null, '&', PHP_QUERY_RFC3986);
        return $this->data['returnUrl']; // . '?' . $query;
    }

    /**
     * Send redirect info to payment gateway.
     */
    public function redirect() {
        header('Content-Type: text/xml; charset=utf-8');
        echo "REDIRECT=" . $this->getRedirectUrl();
        die();
    }
    
}
