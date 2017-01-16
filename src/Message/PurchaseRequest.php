<?php

namespace Omnipay\Constriv\Message;

/**
 * Authorize and immediately capture an amount on the customer's card
 *
 * @author DalPraS
 */
class PurchaseRequest extends AbstractRequest {
    
    public function getData() {
        $this->validate('amount', 'currency', 'cancelUrl', 'returnUrl');
        $data = [
            'id'           => $this->getMerchantId(),
            'password'     => $this->getMerchantPassword(),
            'action'       => self::ACTION_PURCHASE,
            'amt'          => $this->getAmount(),
            'currencycode' => $this->getCurrencyNumeric(),
            'responseURL'  => $this->getReturnUrl(),
            'errorURL'     => $this->getCancelUrl(),
            'langid'       => self::LANG_ITA,
            'trackid'      => $this->getTransactionId(),
//            'udf2'         => $this->getToken()
        ];
        $card = $this->getCard();
        if ($card) {
            $data['udf3'] = 'EMAILADDR:' . $card->getEmail();
        }
        $data['udf5'] = 'HPP_TIMEOUT=20';
        return $data;
    }
    
    /**
     * Send POST to payment gateway
     * 
     * @param array $data 
     *          Post fields data
     * @return PurchaseResponse
     */
    public function sendData($data) {
        // $httpRequest = $this->httpClient->post($this->getEndpoint(), null, http_build_query($data, '', '&'));
        $httpRequest = $this->httpClient->post($this->getEndpoint(), null, $data);
        // CURL_SSLVERSION_TLSv1_2 for libcurl < 7.35
        // $httpRequest->getCurlOptions()->set(CURLOPT_SSLVERSION, 6); 
        $httpRequest->getCurlOptions()->set(CURLOPT_POST, true); 
        $httpRequest->getCurlOptions()->set(CURLOPT_SSL_VERIFYPEER, false); 
        $httpRequest->getCurlOptions()->set(CURLOPT_RETURNTRANSFER, true); 
        $httpResponse = $httpRequest->send();
        return $this->createResponse($httpResponse->getBody());
    }

    /**
     * @param array $data
     * @return PurchaseResponse
     */
    private function createResponse($data) {
        return $this->response = new PurchaseResponse($this, $data);
    }

    public function getEndpoint() {
        return $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }
    
    /**
     * Get the Email
     *
     * This is the customer email
     * 
     * @return string merchant id
     */
    public function getEmail() {
        return $this->getParameter('email');
    }

    /**
     * Set the Email
     *
     * This is the customer email
     *
     * @param  string $value email
     * @return self
     */
    public function setEmail($value) {
        return $this->setParameter('email', $value);
    }

}
