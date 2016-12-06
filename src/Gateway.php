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
            'merchantId'       => '',
            'merchantPassword' => '',
            'testMode'         => false,
        ];
    }

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

    /**
     * Create a purchase request.
     *
     * @param array $parameters
     * 
     * @return \Omnipay\Constriv\Message\PurchaseRequest
     */
    public function purchase(array $parameters = array()) {
        return $this->createRequest('\Omnipay\Constriv\Message\PurchaseRequest', $parameters);
    }

    /**
     * Handle return from off-site gateways after purchase
     * 
     * @param  array $parameters
     * @return \Omnipay\Constriv\Message\CompletePurchaseRequest
     */
    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Constriv\Message\CompletePurchaseRequest', $parameters);
    }
    

}
