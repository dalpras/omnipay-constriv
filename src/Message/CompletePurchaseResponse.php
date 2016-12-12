<?php
namespace Omnipay\Constriv\Message;


class CompletePurchaseResponse extends \Omnipay\Common\Message\AbstractResponse //implements \Omnipay\Common\Message\RedirectResponseInterface
{
    
    public function isSuccessful() {
        return !isset($this->data['code']);
    }
    
}
