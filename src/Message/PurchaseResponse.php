<?php

namespace Omnipay\Constriv\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

/**
 * Constriv Purchase Response
 *
 * @author DalPraS
 */
class PurchaseResponse extends AbstractResponse implements \Omnipay\Common\Message\RedirectResponseInterface {

    public function __construct(RequestInterface $request, $data) {
        $this->request = $request;
        // come da indicazioni del manuale il PG ritorna l'id del pagamento + ":" + url del pagamento
        $match = preg_match('~^([\w]{1,20}):(.+)$~', $data, $matches);
        if ($match) {
            $this->data = [
                'status'     => 'OK',
                'paymentId'  => $matches[1],
                'paymentUrl' => $matches[2]
            ];
        } else {
            $this->data = [
                'status'  => 'KO',
                'message' => $data
            ];
        }
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
        if ($this->isSuccessful()) {
            return $this->data['paymentUrl'] . '?PaymentID=' . $this->data['paymentId'];
        }
        return null;
    }

    /**
     * Gateway Reference
     *
     * @return null|string A reference provided by the gateway to represent this transaction
     */    
    public function getTransactionReference() {
        return $this->isSuccessful() ? $this->data['paymentId'] : null;
    }

    /**
     * Does the response require a redirect?
     *
     * @return boolean
     */
    public function isRedirect() {
        return true;
    }

    public function isSuccessful() {
        return isset($this->data['status']) && $this->data['status'] == 'OK';
    }

    public function getMessage() {
        return isset($this->data['message']) ? $this->data['message'] : null;
    }

}
