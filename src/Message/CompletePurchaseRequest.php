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
        $this->validate('merchantId', 'merchantPassword', 'returnUrl');
        $request = $this->httpRequest->request;
        
        // Error from payment gateway
        if (($error = $request->get('Error'))) {
            $data['code']      = $error;
            $data['message']   = $request->get('ErrorText');
            $data['returnUrl'] = $this->getReturnUrl();
        } else {
            $data = [
//                'token'                => $request->get('udf2', 'invalid-token'), // the token setted during initialization is returned for additional check (optional)
                'transactionReference' => $request->get('tranid'),   // transaction reference created by payment gateway
                'transactionId'        => $request->get('trackid'),  // id created by merchant during authorization 
                'cardtype'             => $request->get('cardtype'), // card type used by customer
                'result'               => $request->get('result'),   // transaction result from payment gateway
                'returnUrl'            => $this->getReturnUrl()
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
        
        // The PaymentId is initiated by gateway and returned with a post from purchase.
        $data['paymentId'] = $this->getPaymentId();
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
        return $this->httpRequest->request->get('paymentid');
    }

//
//    public function setPaymentId($value) {
//        return $this->setParameter('paymentId', $value);
//    }

    /**
     * Send the the destination where to redirect customer to payment gateway
     *
     * @param  mixed $data The data to send
     */
    public function sendData($data) { 
        return new CompletePurchaseResponse($this, $data);
    }

}
