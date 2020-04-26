<?php

namespace Omnipay\Flo2Cash\Message;

use Omnipay\Common\Message\RedirectResponseInterface;
use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

/**
 * Flo2Cash Web Payments Purchase Response
 */
class Web2PayPurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{
    protected $endpoint = 'https://secure.flo2cash.co.nz/web2pay/default.aspx';

    public function isSuccessful()
    {
        return false;
    }

    public function isRedirect()
    {
        return true;
    }

    public function getRedirectUrl()
    {
        return $this->getEndpoint();
    }

    public function getRedirectMethod()
    {
        return 'POST';
    }

    public function getRedirectData()
    {
        return $this->getData();
    }

    protected function getEndpoint()
    {
        return $this->endpoint;
    }
}
