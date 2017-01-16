<?php

namespace Omnipay\Constriv\Message;

/**
 * Constriv Purchase Response
 *
 * @author DalPraS
 */
class PurchaseResponse extends \Omnipay\Common\Message\AbstractResponse implements \Omnipay\Common\Message\RedirectResponseInterface {

    /**
     * Regular expression that matches the body returned by payment gateway.
     * If pattern match the response is successfull, otherwise is not valid.
     */
    const regexMatch = '~^([\w]{1,20}):(.+)$~';

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
        $matches = [];
        return preg_match(self::regexMatch, $this->data, $matches) ? $matches[2] . '?PaymentID=' . $matches[1] : null;
    }

    /**
     * Gateway Reference
     *
     * @return null|string A reference provided by the gateway to represent this transaction
     */    
    public function getTransactionReference() {
        $matches = [];
        return preg_match(self::regexMatch, $this->data, $matches) ? $matches[1] : null;
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
     * Is the response successful?
     *
     * @return boolean
     */    
    public function isSuccessful() {
        return preg_match(self::regexMatch, $this->data);
    }
    
    /**
     * Does the response require a redirect?
     *
     * @return boolean
     */
    public function isRedirect() {
        return $this->isSuccessful();
    }

    public function getMessage() {
        return preg_match(self::regexMatch, $this->data) ? null : $this->data;
    }
}
