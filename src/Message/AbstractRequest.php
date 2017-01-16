<?php

namespace Omnipay\Constriv\Message;

/**
 * Description of AbstractRequest
 * 
 * #### Constriv Account Payment
 *
 * This is for the use case where the customer intends to pay using their
 * VISA/MASTERCARD card. Note that no credit card details are provided, 
 * instead both a return URL and a cancel URL are required.
 *
 * The optimal solution here is to provide a unique return URL and cancel
 * URL per transaction. That way your code will know what transaction is
 * being returned or cancelled by Constriv.
 *
 * So step 1 is to store some transaction data somewhere on your system so
 * that you have an ID when your transaction returns.  How you do this of
 * course depends on what framework, database layer, etc, you are using but
 * for this step let's assume that you have a class set up that can save
 * a transaction and return the object, and that you can retrieve the ID
 * of that saved object using some call like getId() on the object.  Most
 * ORMs such as Doctrine ORM, Propel or Eloquent will have some methods
 * that will allow you to do this or something similar.
 *
 * <code>
 *   $transaction = MyClass::saveTransaction($some_data);
 *   $txn_id = $transaction->getId();
 * </code>
 *
 * Step 2 is to send the purchase request.
 * 
 * The returnUrl is the address where the gateway ask where to redirect
 * the customer. Session variables at that address will not work because 
 * the session if that of the gateway, nor the customer client.
 * 
 * The response return a paymentId of the transaction initiated that we need to 
 * store somewhere for matching in step 4.
 * 
 * <code>
 *   // Do a purchase transaction on the gateway
 *   try {
 *       $transaction = $gateway->purchase(array(
 *           'amount'        => '10.00',
 *           'currency'      => 'EUR',
 *           'transactionId' => $txn_id,
 *           'returnUrl'     => 'http://mysite.com/pay/return/?txn_id=' . $txn_id,,
 *           'cancelUrl'     => 'http://mysite.com/pay/return/?txn_id=' . $txn_id,,
 *           'email'         => $email 
 *       ));
 *       $response = $transaction->send();
 *       $data = $response->getData();
 *       echo "Gateway purchase response data == " . print_r($data, true) . "\n";
 *
 *       $paymentId = $response->getTransactionReference();
 * 
 *       if ($response->isSuccessful()) {
 *           echo "Step 2 was successful!\n";
 *       }
 *
 *   } catch (\Exception $e) {
 *       echo "Exception caught while attempting purchase.\n";
 *       echo "Exception type == " . get_class($e) . "\n";
 *       echo "Message == " . $e->getMessage() . "\n";
 *   }
 * </code>
 *
 * Step 3 is where your code needs to redirect the customer to the gateway 
 * so that the customer can pay with the Card and agree to authorize the payment.
 * The response will implement an interface
 * called RedirectResponseInterface from which the redirect URL can be obtained.
 *
 * How you do this redirect is up to your platform, code or framework at
 * this point.  For the below example I will assume that there is a
 * function called redirectTo() which can handle it for you.
 *
 * <code>
 *   if ($response->isRedirect()) {
 *       // Redirect the customer to payment gateway so that they can sign in and
 *       // authorize the payment.
 *       echo "The transaction is a redirect";
 *       redirectTo($response->getRedirectUrl()); // or $response->redirect()
 *   }
 * </code>
 * 
 * Step 4 is for the gateway who need to know where to redirect the customer.
 * 
 * The gateway ask where to redirect the customer to the merchant site after the user has payed or
 * cancelled the operation. The gateway return the paymentId to the merchant,
 * the result of the customer operation and other details about the transaction
 * performed.
 * 
 * In the purchaseRequest the returnUrl is passed to gateway for redirecting
 * the customer. The $paymentId is available in $purchaseRequest and $purchaseResponse.
 * 
 * When calling $purchaseResponse->redirect(), the redirect information is passed 
 * back the the payment gateway the will redirect the customer to the returlUrl
 * specified.
 * 
 * <code>
 *   $purchaseRequest = $gateway->completePurchase([
 *       'returnUrl' => $returnUrl
 *   ]);
 *   $paymentId = $purchaseRequest->getPaymentId();
 * 
 *   $purchaseResponse = $purchaseRequest->send();
 * 
 *   $paymentId = $purchaseResponse->getPaymentId();
 * 
 *   if ($purchaseResponse->isRedirect()) {
 *     $purchaseResponse->redirect();
 *   }
 * </code>
 * 
 * Step 5 is where the customer is redirected to your site by the payment gateway.  
 * This will happen on the returnUrl, that you provided in the completePurchase()
 * call.
 * Note this example assumes that the purchase has been successful or not.
 * A page of greetings will show the transaction results.
 */
abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest {

    /**
     * Constriv purchase Action
     */
    const ACTION_PURCHASE      = 1;
    const ACTION_AUTHORIZATION = 4;

    /**
     * Constriv endpoint gateway language
     */
    const LANG_ITA = 'ITA';
    const LANG_USA = 'USA';
    const LANG_FRA = 'FRA';
    const LANG_DEU = 'DEU';
    const LANG_ESP = 'ESP';
    const LANG_SLO = 'SLO';
    const LANG_SRB = 'SRB';
    const LANG_POR = 'POR';
    const LANG_RUS = 'RUS';
    
    /**
     * Live EndPoint
     *
     * @var string
     */ 
    protected $liveEndpoint = 'https://ipg.constriv.com/IPGWeb/servlet/PaymentInitHTTPServlet';
    
    /**
     * Developer EndPoint
     *
     * @var string
     */    
    protected $testEndpoint = 'https://test4.constriv.com/cg301/servlet/PaymentInitHTTPServlet';
//    protected $testEndpoint = 'http://localhost/it/it/pay/mockup/payment-init';    

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

    
}
