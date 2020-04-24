<?php

namespace Omnipay\Flo2Cash\Message;

/**
 * Flo2Cash Web Payments Complete Purchase Request
 */
class Web2PayCompletePurchaseRequest extends Web2PayCompleteAuthorizeRequest
{
    public function getData()
    {
        $data = parent::getData();
        $data['PAYMENTREQUEST_0_PAYMENTACTION'] = 'Sale';

        return $data;
    }

    protected function createResponse($data)
    {
        return $this->response = new Web2PayCompletePurchaseResponse($this, $data);
    }
}
