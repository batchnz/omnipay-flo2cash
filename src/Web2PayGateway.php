<?php

namespace Omnipay\Flo2Cash;

use Omnipay\Common\AbstractGateway;

/**
 * Flo2Cash Web Payments Class
 */
class Web2PayGateway extends AbstractGateway
{
    const RETURN_OPTION_RETURN_TO_URL = 'returnToUrl';
    const RETURN_OPTION_DISPLAY_IN_WEBPAYMENTS = 'displayInWebPayments';

    const PAYMENT_METHOD_STANDARD = 'standard';
    const PAYMENT_METHOD_UNIONPAY = 'unionpay';
    const PAYMENT_METHOD_MASTERPASS = 'masterpass';

    public function getName()
    {
        return 'Flo2Cash Web Payments';
    }

    public function getDefaultParameters()
    {
        $settings['cmd'] = '_xclick';
        $settings['accountId'] = '';
        $settings['storeCard'] = 0;
        $settings['displayCustomerEmail'] = 1;

        return $settings;
    }

     /**
     * Defines the Web Payments integration service. Always use “_xclick” for Web Payments Standard Payment.
     * Required
     * @var string
     */
    public function setCmd($value)
    {
        return $this->setParameter('cmd',  $value);
    }

    public function getCmd()
    {
         return $this->getParameter('cmd');
    }

    /**
     * Flo2Cash issued Account ID
     * Required
     * @var int
     */
    public function setAccountId($value)
    {
        return $this->setParameter('accountId',  $value);
    }

    public function getAccountId()
    {
         return $this->getParameter('accountId');
    }

    /**
     * The transaction amount in NZ dollars. Must be a positive value.
     * Required
     * @var float
     */
    public function setAmount($value)
    {
        return $this->setParameter('amount',  $value);
    }

    public function getAmount()
    {
         return $this->getParameter('amount');
    }

    /**
     * Description of item, not stored by Flo2Cash.
     * Required
     * @var string
     */
    public function setItemName($value)
    {
        return $this->setParameter('itemName',  $value);
    }

    public function getItemName()
    {
         return $this->getParameter('itemName');
    }

    /**
     * Merchant defined value stored with the transaction.
     * Optional
     * 50 characters max
     * @var string
     */
    public function setReference($value)
    {
        return $this->setParameter('reference',  $value);
    }

    public function getReference()
    {
         return $this->getParameter('reference');
    }

    /**
     * Merchant defined value stored with the transaction.
     * Optional
     * 50 characters max
     * @var string
     */
    public function setParticular($value)
    {
        return $this->setParameter('particular',  $value);
    }

    public function getParticular()
    {
         return $this->getParameter('particular');
    }

    /**
     * The URL that the customer will be sent to on completion of the payment. This must be a publicly accessible URL.
     * Required
     * 1024 characters max
     * @var string
     */
    public function setReturnUrl($value)
    {
        return $this->setParameter('returnUrl',  $value);
    }

    public function getReturnUrl()
    {
         return $this->getParameter('returnUrl');
    }

    /**
     * If provided, this URL will be used in conjunction with Flo2Cashs Merchant Notification Service (MNS). (See MNSfor details) This must be a publicly accessible URL.
     * Optional
     * 1024 characters max
     * @var string
     */
    public function setNotificationUrl($value)
    {
        return $this->setParameter('notificationUrl',  $value);
    }

    public function getNotificationUrl()
    {
         return $this->getParameter('notificationUrl');
    }

    /**
     * The URL to an image. Sets the image at the top of the payment page. The image can be of any height but must be a maximum of 600px wide and must be URLencoded.
     * The URL must end with  one  of  the  following  image  extensions “.jpg”, “.jpeg”, “.png”, “.bmp”, “.gif”.
     * Flo2Cash  recommends  that  you  provide  an image that is stored only on a secure (HTTPS) server. (See Customising the Flo2Cash Interface).
     * Optional
     * 1024 characters max
     * @var string
     */
    public function setHeaderImage($value)
    {
        return $this->setParameter('headerImage',  $value);
    }

    public function getHeaderImage()
    {
         return $this->getParameter('headerImage');
    }

    /**
     * Sets the colour of the border underneath the header on the Flo2Cash hosted payment page. (See Customising the Flo2Cash Interface).
     * Value must be a 6-character hexadecimal value for the colour required.
     * Optional
     * 6 characters max
     * @var string
     */
    public function setHeaderBottomBorder($value)
    {
        return $this->setParameter('headerBottomBorder',  $value);
    }

    public function getHeaderBottomBorder()
    {
         return $this->getParameter('headerBottomBorder');
    }

    /**
     * Sets the background colour of the header section on the Flo2Cash hosted payment page. (See Customising the Flo2Cash Interface).
     * Value must be a 6-characterhexadecimal value for the colour required.
     * Optional
     * 6 characters max
     * @var string
     */
    public function setHeaderBackgroundColour($value)
    {
        return $this->setParameter('headerBackgroundColour',  $value);
    }

    public function getHeaderBackgroundColour()
    {
         return $this->getParameter('headerBackgroundColour');
    }

    /**
     * Merchant defined value that you can use to identify your transaction.
     * Any value passed in will be posted back to the notification_url (See MNS).
     * This is a pass-throughfield that is never presented to your customer. Flo2Cash will not store this value.
     * Optional
     * 1024 characters max
     * @var string
     */
    public function setCustomData($value)
    {
        return $this->setParameter('customData',  $value);
    }

    public function getCustomData()
    {
         return $this->getParameter('customData');
    }

    /**
     * 0 or 1 as to whether Web Payments should display the option for storing the card details upon a successful payment. 0 = do not show (default) 1 = show
     * Optional
     * @var int
     */
    public function setStoreCard($value)
    {
        return $this->setParameter('storeCard',  $value);
    }

    public function getStoreCard()
    {
         return $this->getParameter('storeCard');
    }

    /**
     * 0 or 1 as to whether Web Payments should display customer email receipt field. 1 = display (default) 0 = hide
     * Optional
     * @var int
     */
    public function setDisplayCustomerEmail($value)
    {
        return $this->setParameter('displayCustomerEmail',  $value);
    }

    public function getDisplayCustomerEmail()
    {
         return $this->getParameter('displayCustomerEmail');
    }

    /**
     * If not set and the merchant is configured to accept more than one card payment types, the customer will be presented with a payment method selection page before completing the card payment.
     * For example, if the merchant accepts Visa, MasterCard and UnionPay, the customers will be presented with a payment method selection page presenting the two options of either paying with Visa/MasterCard or UnionPay card.
     * Merchants can, however, pre-select the preferred payment method using this parameter.
     * The following strings are supported values (both in lower case):
     *     -standard
     *     -unionpay
     *     -masterpass
     * If the value “standard” is passed, the customer will be directed to the standard Visa/MasterCard entry page, skipping the payment method selection page.
     * If the value “masterpass” is passed, the customer will be directed to the masterpass wallet processing flow, skipping the payment method selection page.
     * Similarly, if the value “unionpay” is passed, the customer will be directed to the UnionPay card transaction processing flow, skipping the payment method selection page.
     * Optional
     * 50 characters max
     * @var string
     */
    public function setPaymentMethod($value)
    {
        return $this->setParameter('paymentMethod',  $value);
    }

    public function getPaymentMethod()
    {
         return $this->getParameter('paymentMethod');
    }

    /**
     * This is a SHA1 hash of the data that you are passing plus your secret hash key (explained above).
     * Please see the appendix (Flo2Cash Calculating the merchant_verifier input parameter value for Standard Payments) for sample code on how to calculate this field.
     * Required
     * @var string
     */
    public function setMerchantVerifier($value)
    {
        return $this->setParameter('merchantVerifier',  $value);
    }

    public function getMerchantVerifier()
    {
         return $this->getParameter('merchantVerifier');
    }

    /**
     * Your secret hash key is used to provide tamper proof message transfer between you and the Flo2Cash Web Payments application
     * @author Josh Smith <josh@batch.nz>
     * @param  string $value
     */
    public function setSecretKey($value)
    {
        return $this->setParameter('secretKey', $value);
    }

    public function getSecretKey()
    {
        return $this->getParameter('secretKey');
    }

    /**
     * The return option manages how your online payment page works once a customer makes a payment.
     * @author Josh Smith <josh@batch.nz>
     * @param  string $value
     */
    public function setReturnOption($value)
    {
        return $this->setParameter('returnOption', $value);
    }

    public function getReturnOption()
    {
        return $this->getParameter('returnOption');
    }

    /**
     * Whether to use the shopping cart or not
     * @author Josh Smith <josh@batch.nz>
     * @param  boolean $value
     */
    public function setUseShoppingCart($value)
    {
        return $this->setParameter('useShoppingCart', $value);
    }

    public function getUseShoppingCart()
    {
        return $this->getParameter('useShoppingCart');
    }

    /**
     * Passing this variable (value must be “1”) will allow you to collect customer information from the Flo2Cash Web Payments shopping cart page.
     * The customer information will then be posted back to your notification URL
     * Optional
     * @var int
     */
    public function setCustomerInfoRequired($value)
    {
        return $this->setParameter('customerInfoRequired', $value);
    }

    public function getCustomerInfoRequired()
    {
        return $this->getParameter('customerInfoRequired');
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Flo2Cash\Message\Web2PayPurchaseRequest', $parameters);
    }

    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Flo2Cash\Message\Web2PayCompletePurchaseRequest', $parameters);
    }
}
