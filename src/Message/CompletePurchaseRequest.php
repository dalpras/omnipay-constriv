<?php

namespace Omnipay\Constriv\Message;

/**
 * Description of CompleteAuthorizeRequest
 *
 * @author DalPraS
 */
class CompletePurchaseRequest extends AbstractRequest {
    
    /**
     * Get the data for this request.
     *
     * @throws InvalidRequestException
     * @return string                  request data
     */
    public function getData()
    {
        $this->validate('merchantId', 'merchantPassword', 'token', 'returnUrl');
        $paymentId = $this->httpRequest->request->get('paymentid');
        
        // Error from payment gateway
        if (($error = $this->httpRequest->request->get('Error'))) {
            return [
                'paymentId' => $paymentId,
                'code'      => $error,
                'message'   => $this->httpRequest->request->get('ErrorText')
            ];
        }
        
        // token to match
        $token = $this->httpRequest->request->get('udf2');
        
        // invalid match
        if ( ($token !== null) && ($token != $this->getToken()) ) {
            return [
                'paymentId' => $paymentId,
                'code'      => 'xxx',
                'message'   => 'Initialization token not matching!'
            ];
        }
        
        // transaction reference created by payment gateway
        $transactionReference = $this->httpRequest->request->get('tranid');
        
        // created by merchant during authorization 
        $transactionId = $this->httpRequest->request->get('trackid'); 
        
        // card type used by customer
        $cardtype = $this->httpRequest->request->get('cardtype'); 
        
        // transaction result from payment gateway
        $result = $this->httpRequest->request->get('result'); 
        
        $data = [
            'paymentId'            => $paymentId,
            'transactionReference' => $transactionReference,
            'transactionId'        => $transactionId,
            'cardtype'             => $cardtype,
            'result'               => $result
        ];

        return $data;
    }    
    
    /**
     * Send the the destination to which redirect customer to payment gateway
     *
     * @param  mixed $data The data to send
     */
    public function sendData($data)
    {
        // if there are not errors display redirect message for payment gateway
        if ( isset($data['code']) && $data['code'] !== null ) {
            echo "REDIRECT=" . $this->getReturnUrl();    
            die();
        } 
        return new CompletePurchaseResponse($this, $data);
    }    
    
}
