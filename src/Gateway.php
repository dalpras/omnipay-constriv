<?php

namespace Omnipay\Constriv;

use Omnipay\Common\AbstractGateway;

class Gateway extends AbstractGateway {

    /**
     * Il sistema bancario ha rifiutato la transazione a causa di timeout o dati di invio errati.
     */
//    const STATUS_BANK_ERROR = -2;
//    const STATUS_BANK_ERROR_DESC = "Rifiutato";

    /**
     * Comunicazione avvenuta dal sistema bancario, ma ordine non corrispondente sul sistema Vimar.
     */
//    const STATUS_INTERNAL_ERROR = -1;
//    const STATUS_INTERNAL_ERROR_DESC = "Errore";

    /**
     * Ordine iniziato e inviato al PaymentGateway
     */
//    const STATUS_ON_GOING = 0;
//    const STATUS_ON_GOING_DESC = "Iniziato";

    /**
     * Ordine e transazione completati correttamente.
     * La somma è stata addebitata correttamente nella carta di credito del'utente.
     */
//    const STATUS_SUCCEDED = 1;
//    const STATUS_SUCCEDED_DESC = "Completato";

    /**
     * Ordine inviato correttamente al sistema bancario, ma transazione non autorizzata.
     */
//    const STATUS_BLOCKED = 2;
//    const STATUS_BLOCKED_DESC = "Non autorizzato";

//    const ACTION_PURCHASE = 1;
//    const ACTION_AUTHORIZATION = 4;

//    const CURRENCY_EURO = 978;
//    const LANG_ITA = 'ITA';    
    
    public function getName() {
        return 'Constriv';
    }

    public function getDefaultParameters() {
        return [
            'id'           => '', // $config->pay->merchantId, // username
            'password'     => '', // $config->pay->merchantPassword,
//            'action'       => self::ACTION_PURCHASE,
//            'amt'          => sprintf("%0.2F", $order->getAmount()),
//            'currencycode' => self::CURRENCY_EURO,
//            'langid'       => self::LANG_ITA,
//            'responseURL'  => $responseUrl,
//            'errorURL'     => $errorURL,
//            'trackid'      => $order->getId(),
//            'udf2'         => $order->getToken(),
//            'udf3'         => 'EMAILADDR:' . $order->getProfile()->getEmail(),
//            'udf5'         => 'HPP_TIMEOUT=20',
            'testMode' => false,
        ];        
    }

    public function getId() {
        return $this->getParameter('id');
    }

    public function setId($value) {
        return $this->setParameter('id', $value);
    }

    public function getPassword() {
        return $this->getParameter('password');
    }

    public function setPassword($value) {
        return $this->setParameter('password', $value);
    }

    /**
     * Create an authorize request.
     *
     * @param array $parameters
     * 
     * @return \Omnipay\Constriv\Message\CompletePurchaseRequest
     */
    public function authorize(array $parameters = array()) {
        return $this->createRequest('\Omnipay\Constriv\Message\AuthorizeRequest', $parameters);
    }

    /**
     * Create a purchase request.
     *
     * @param array $parameters
     * @return \Omnipay\Dummy\Message\AuthorizeRequest
     */
    public function purchase(array $parameters = array()) {
        return $this->createRequest('\Omnipay\Constriv\Message\PurchaseRequest', $parameters);
    }

}
