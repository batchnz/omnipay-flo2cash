<?php

namespace Omnipay\Flo2Cash\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Flo2Cash\Support\InstantUpdateApi\ShippingOption;
use Omnipay\Flo2Cash\Support\InstantUpdateApi\BillingAgreement;

/**
 * Flo2Cash Web Payments Purchase Request
 */
class Web2PayPurchaseRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('amount', 'returnUrl');
        $data = $this->getBaseData();

        $data['account_id'] = $this->getAccountId();
        $data['amount'] = $this->getAmount();
        $data['reference'] = $this->getReference();
        $data['particular'] = $this->getParticular();
        $data['return_url'] = $this->getReturnUrl();
        $data['notification_url'] = $this->getNotificationUrl();
        $data['header_image'] = $this->getHeaderImage();
        $data['header_bottom_border'] = $this->parseHexColor($this->getHeaderBottomBorder());
        $data['header_background_colour'] = $this->parseHexColor($this->getHeaderBackgroundColour());
        $data['custom_data'] = $this->getCustomData();
        $data['store_card'] = $this->getStoreCard();
        $data['display_customer_email'] = $this->getDisplayCustomerEmail();
        $data['payment_method'] = $this->getPaymentMethod();
        $data['merchant_verifier'] = $this->calcMerchantVerifier();

        if( $this->getUseShoppingCart() ) {
            $data = array_merge($data, $this->getItemData());
        }

        // Remove unused data properties
        foreach ($data as $key => $value) {
            if( empty($data[$key]) ) unset($data[$key]);
        }

        return $data;
    }

    protected function createResponse($data)
    {
        return $this->response = new Web2PayPurchaseResponse($this, $data);
    }

    /**
     * Parses and validates a hex color
     * Strips prefixed hash
     * @author Josh Smith <josh@batch.nz>
     * @param  string $color Hex color to validate
     * @return string
     */
    protected function parseHexColor(string $color) {
        // Strip prefixed hash
        $color = str_replace('#', '', $color);

        // Validate this is a hex color
        if( !(ctype_xdigit($color) && strlen($color) === 6) ) return '';

        return $color;
    }
}
