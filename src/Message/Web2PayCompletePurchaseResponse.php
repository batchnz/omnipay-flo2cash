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
    const TXN_STATUS_UNKNOWN = 0;
    const TXN_STATUS_PROCESSING = 1;
    const TXN_STATUS_SUCCESSFUL = 2;
    const TXN_STATUS_FAILED = 3;
    const TXN_STATUS_BLOCKED = 4;
    const TXN_STATUS_DECLINED = 11;

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
        // Bail if we don't have a valid success status
        if( $this->request->getTxnStatus() !== self::TXN_STATUS_SUCCESSFUL ) {
            return false;
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
            trim($this->request->getTxnId()),
            trim($this->request->getReceiptNo()),
            trim($this->request->getTxnStatus()),
            trim($this->request->getAccountId()),
            trim($this->request->getReference()),
            trim($this->request->getParticular()),
            trim($this->request->getCardType()),
            trim($this->request->getAmount()),
            trim($this->request->getResponseCode()),
            trim($this->request->getResponseText()),
            trim($this->request->getCustomerEmail()),
            trim($this->request->getAuthorisationCode()),
            trim($this->request->getErrorMessage()),
            trim($this->request->getErrorCode()),
            trim($this->request->getCustomData()),
            trim($this->request->getCardToken()),
            trim($this->request->getDate()),
            trim($this->request->getCheckoutId()),
            trim($this->request->getSessionId()),
            trim($this->request->getBlockedReason()),
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
