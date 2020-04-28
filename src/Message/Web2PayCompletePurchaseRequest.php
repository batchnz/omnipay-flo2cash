<?php

namespace Omnipay\Flo2Cash\Message;

/**
 * Flo2Cash Web Payments Complete Purchase Request
 */
class Web2PayCompletePurchaseRequest extends AbstractRequest
{

    /**
     * Flo2Cash defined unique transaction ID.
     * @author Josh Smith <josh@batch.nz>
     * @param  string $value
     */
    public function setTxnId($value)
    {
        $this->setParameter('txnId', $value);
    }

    public function getTxnId()
    {
        return $this->getParameter('txnId');
    }

    /**
     * Flo2Cash unique transaction receipt number.
     * @author Josh Smith <josh@batch.nz>
     * @param  int $value
     */
    public function setReceiptNo($value)
    {
        $this->setParameter('receiptNo', $value);
    }

    public function getReceiptNo()
    {
        return $this->getParameter('receiptNo');
    }

    /**
     * 0 = Unknown – Transaction  result  cannot  be confirmed  i.e.  lost  connection  with  the  payment switch
     * 1 = Processing – An old status left in for legacy integrations (Ignore)
     * 2 = Successful – Transaction processed successfully and monies were taken from the card
     * 3 = Failed – Transaction has failed to process
     * 4 = Blocked – Transaction  was  blocked  from taking place due to merchant specific rules
     * 11 = Declined – Transaction  was  processed  but declined
     * @author Josh Smith <josh@batch.nz>
     * @param  int $value
     */
    public function setTxnStatus($value)
    {
        $this->setParameter('txnStatus', $value);
    }

    public function getTxnStatus()
    {
        return $this->getParameter('txnStatus');
    }

    /**
     * The credit card type used for this transaction:
     *     1 = American Express
     *     3 = Diners Club
     *     4 = MasterCard
     *     5 = Visa Card
     *     6 = China Union Pay
     * @author Josh Smith <josh@batch.nz>
     * @param  int $value
     */
    public function setCardType($value)
    {
        $this->setParameter('cardType', $value);
    }

    public function getCardType()
    {
        return $this->getParameter('cardType');
    }

    /**
     * If an error occurred,then the error message will be stored here
     * @author Josh Smith <josh@batch.nz>
     * @param  string $value
     */
    public function setResponseText($value)
    {
        return $this->setParameter('responseText', $value);
    }

    public function getResponseText()
    {
        return $this->getParameter('responseText');
    }

    public function setResponseMessage($value)
    {
        return $this->setParameter('responseMessage', $value);
    }

    public function getResponseMessage()
    {
        return $this->getParameter('responseMessage');
    }

    public function setCustomerEmail($value)
    {
        return $this->setParameter('customerEmail', $value);
    }

    public function getCustomerEmail()
    {
        return $this->getParameter('customerEmail');
    }

    /**
     * The response code is a legacy field and is now superseded by the txn_status field as above.
     * The values for the response_code are:
     *     0 = Successful
     *     1 = Failed
     * @author Josh Smith <josh@batch.nz>
     * @param  string $value
     */
    public function setResponseCode($value)
    {
        $this->setParameter('responseCode', $value);
    }

    public function getResponseCode()
    {
        return $this->getParameter('responseCode');
    }

    /**
     * Authorisation code returned by the bank for this transaction
     * @author Josh Smith <josh@batch.nz>
     * @param  string $value
     */
    public function setAuthorisationCode($value)
    {
        $this->setParameter('authorisationCode', $value);
    }

    public function getAuthorisationCode()
    {
        return $this->getParameter('authorisationCode');
    }

    /**
     * The error code indicating the type of error that occurred.
     * @author Josh Smith <josh@batch.nz>
     * @param  string $value
     */
    public function setErrorCode($value)
    {
        $this->setParameter('errorCode', $value);
    }

    public function getErrorCode()
    {
        return $this->getParameter('errorCode');
    }

    /**
     * The error message explaining what the error means.
     * @author Josh Smith <josh@batch.nz>
     * @param  string $value
     */
    public function setErrorMessage($value)
    {
        $this->setParameter('errorMessage', $value);
    }

    public function getErrorMessage()
    {
        return $this->getParameter('errorMessage');
    }

    /**
     * The token of the newly stored card, only available if the store_card variable was set to 1 and the customer chose to store their card details
     * @author Josh Smith <josh@batch.nz>
     * @param  string $value
     */
    public function setCardToken($value)
    {
        $this->setParameter('cardToken', $value);
    }

    public function getCardToken()
    {
        return $this->getParameter('cardToken');
    }

    public function setDate($value)
    {
        $this->setParameter('date', $value);
    }

    public function getDate()
    {
        return $this->getParameter('date');
    }

    public function setCheckoutId($value)
    {
        $this->setParameter('checkoutId', $value);
    }

    public function getCheckoutId()
    {
        return $this->getParameter('checkoutId');
    }

    public function setSessionId($value)
    {
        $this->setParameter('sessionId', $value);
    }

    public function getSessionId()
    {
        return $this->getParameter('sessionId');
    }

    public function setBlockedReason($value)
    {
        $this->setParameter('blockedReason', $value);
    }

    public function getBlockedReason()
    {
        return $this->getParameter('blockedReason');
    }

    /**
     * This is a SHA1 hash of the data that we pass back to you plus your secret hash key.
     * @author Josh Smith <josh@batch.nz>
     * @param  string $value
     */
    public function setPaymentProviderVerifier($value)
    {
        $this->setParameter('paymentProviderVerifier', $value);
    }

    public function getPaymentProviderVerifier()
    {
        return $this->getParameter('paymentProviderVerifier');
    }

    public function getData()
    {
        return [
            'txn_id'                    => $this->getTxnId(),
            'receipt_no'                => $this->getReceiptNo(),
            'txn_status'                => $this->getTxnStatus(),
            'account_id'                => $this->getAccountId(),
            'reference'                 => $this->getReference(),
            'particular'                => $this->getParticular(),
            'card_type'                 => $this->getCardType(),
            'response_text'             => $this->getResponseText(),
            'response_message'          => $this->getResponseMessage(),
            'customer_email'            => $this->getCustomerEmail(),
            'response_code'             => $this->getResponseCode(),
            'amount'                    => $this->getAmount(),
            'authorisation_code'        => $this->getAuthorisationCode(),
            'error_code'                => $this->getErrorCode(),
            'error_message'             => $this->getErrorMessage(),
            'custom_data'               => $this->getCustomData(),
            'card_token'                => $this->getCardToken(),
            'date'                      => $this->getDate(),
            'checkout_id'               => $this->getCheckoutId(),
            'session_id'                => $this->getSessionId(),
            'blocked_reason'            => $this->getBlockedReason(),
            'payment_provider_verifier' => $this->getPaymentProviderVerifier(),
        ];
    }

    protected function createResponse($data)
    {
        return $this->response = new Web2PayCompletePurchaseResponse($this, $data);
    }
}
