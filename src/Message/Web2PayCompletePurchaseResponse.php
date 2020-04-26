<?php

namespace Omnipay\Flo2Cash\Message;

use Omnipay\Flo2Cash\Web2PayGateway as Gateway;
use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

/**
 * Flo2Cash Web Payments Complete Payment Response
 */
class Web2PayCompletePurchaseResponse extends AbstractResponse
{
    protected $message = '';

    public function __construct(RequestInterface $request, $data)
    {
        parent::__construct($request, $data);
        $this->message = $this->data['response_text'];
    }

    /*
     * Is this complete purchase response successful? Will not be successful if it's a redirect response.
     *
     * @return bool
     */
    public function isSuccessful()
    {
        // This option requires no further processing
        if( $this->request->getReturnOption() === Gateway::RETURN_OPTION_DISPLAY_IN_WEBPAYMENTS ){
            return true;
        }

        // Verify the transaction
        $verifiedTransaction = $this->verifyTransaction();

        if( $verifiedTransaction === false ){
            $this->message = 'Unable to verify transaction.';
        }

        return $verifiedTransaction;
    }

    /**
     * @inheritdoc
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @inheritdoc
     */
    public function getTransactionReference()
    {
        return $this->data['receipt_no'];
    }

    /**
     * @inheritdoc
     */
    public function getTransactionId()
    {
        return $this->data['txn_id'];
    }

    /**
     * @inheritdoc
     */
    public function getCode()
    {
        return $this->data['authorisation_code'];
    }

    /**
     * Verifies the response from the gateway hasn't been tampered with
     * @author Josh Smith <josh@batch.nz>
     * @return boolean
     */
    public function verifyTransaction()
    {
        $data = [
            trim($this->data['txn_id'] ?? ''),
            trim($this->data['receipt_no'] ?? ''),
            trim($this->data['txn_status'] ?? ''),
            trim($this->data['account_id'] ?? ''),
            trim($this->data['reference'] ?? ''),
            trim($this->data['particular'] ?? ''),
            trim($this->data['card_type'] ?? ''),
            trim($this->data['amount'] ?? ''),
            trim($this->data['response_code'] ?? ''),
            trim($this->data['response_text'] ?? ''),
            trim($this->data['customer_email'] ?? ''),
            trim($this->data['authorisation_code'] ?? ''),
            trim($this->data['error_message'] ?? ''),
            trim($this->data['error_code'] ?? ''),
            trim($this->data['custom_data'] ?? ''),
            trim($this->data['card_token'] ?? ''),
            trim($this->data['date'] ?? ''),
            trim($this->data['checkout_id'] ?? ''),
            trim($this->data['session_id'] ?? ''),
            trim($this->data['blocked_reason'] ?? ''),
            trim($this->request->getSecretKey())
        ];

        // Implement C# style hashing
        $strToHash = implode('', $data);
        $utfString = mb_convert_encoding($strToHash, "UTF-8");
        $hashTag = sha1($utfString, true);
        $base64Tag = base64_encode($hashTag);

        return $base64Tag === $this->data['payment_provider_verifier'];
    }
}
