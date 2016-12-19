<?php

namespace Omnipay\Constriv\Message;

/**
 * Description of CompleteAuthorizeRequest
 *
 * @author DalPraS
 */
class CompletePurchaseRequest extends AbstractRequest {
    
    /**
     * PaymentId initiated by gateway and returned with a post from purchase.
     * 
     * @var string
     */
    private $paymentId;
    
    /**
     * Get the data for this request.
     *
     * @throws InvalidRequestException
     * @return string                  request data
     */
    public function getData()
    {
        $request = $this->httpRequest->request;
        
        $this->validate('merchantId', 'merchantPassword', /*'token',*/ 'returnUrl');
        
        // Error from payment gateway
        if (($error = $request->get('Error'))) {
            return [
                'paymentId' => $this->getPaymentId(),
                'code'      => $error,
                'message'   => $request->get('ErrorText'),
                'returnUrl' => $this->getReturnUrl()
            ];
        }
        
        // token to match
//        $token = $request->get('udf2');
//        
//        // invalid match
//        if ( ($token !== null) && ($token != $this->getToken()) ) {
//            return [
//                'paymentId' => $paymentId,
//                'code'      => 'token',
//                'message'   => 'Initialization token not matching!'
//            ];
//        }
        
        // transaction reference created by payment gateway
        $transactionReference = $request->get('tranid');
        
        // created by merchant during authorization 
        $transactionId = $request->get('trackid'); 
        
        // card type used by customer
        $cardtype = $request->get('cardtype'); 
        
        // transaction result from payment gateway
        $result = $request->get('result'); 
        
        // the token setted during initialization is returned for additional check (optional)
        $token = $request->get('udf2', 'invalid-token');
        
        $data = [
            'paymentId'            => $this->getPaymentId(),
            'token'                => $token,
            'transactionReference' => $transactionReference,
            'transactionId'        => $transactionId,
            'cardtype'             => $cardtype,
            'result'               => $result,
            'returnUrl'            => $this->getReturnUrl()
        ];

        return $data;
    }    
    
    /**
     * Id of the payment initiated by the payment gateway created during initialization.
     * The paymentId is returned by gateway when invoking completePurchase and is needed to 
     * fullfill the returnUrl before getData is called.
     * 
     * The id of the payment is always returned during completePurchase from the gateway, so
     * it's possible to use this value for a complete stateless payment workflow, because it doesnt rely
     * on user sessions.
     */
    public function getPaymentId() {
        if ($this->paymentId === null) {
            $this->paymentId = $this->httpRequest->request->get('paymentid');
        } 
        return $this->paymentId;
    }    
    
    /**
     * Send the the destination where to redirect customer to payment gateway
     *
     * @param  mixed $data The data to send
     */
    public function sendData($data) { 
        return new CompletePurchaseResponse($this, $data);
    }

}
