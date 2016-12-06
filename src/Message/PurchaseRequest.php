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

        $data = [];
        $data['id'] = $this->getMerchantId();
        $data['password'] = $this->getMerchantPassword();
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
        return $this->response = new PurchaseResponse($this, $data);
    }

    public function getEndpoint() {
        return $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }

//    public function getHttpRequest() {
//        return $this->httpRequest;
//    }
    
    
}
