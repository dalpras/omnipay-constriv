<?php

namespace Omnipay\Constriv\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

/**
 * Constriv Complete Purchase Response
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
                'paymentUrl' => $matches[2],
            ];
        } else {
            $this->data = [
                'status'     => 'KO',
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
        $result = $this->data['paymentUrl'] . '?PaymentID=' . $this->data['paymentId'];
        return $result;
    }

    public function isSuccessful() {
        return isset($this->data['status']) && $this->data['status'] == 'OK';
    }

    public function isCancelled() {
        return isset($this->data['status']) && $this->data['status'] == 'KO';
    }

    public function getTransactionReference() {
        return isset($this->data['paymentId']) ? $this->data['paymentId'] : null;
    }

    public function getMessage() {
        return NULL;
//        return isset($this->data['rawAuthMessage']) ? $this->data['rawAuthMessage'] : null;
    }

}
