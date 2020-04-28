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
        if( (int) $this->request->getTxnStatus() !== self::TXN_STATUS_SUCCESSFUL ) {
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
            trim((string) $this->request->getTxnId()),
            trim((string) $this->request->getReceiptNo()),
            trim((string) $this->request->getTxnStatus()),
            trim((string) $this->request->getAccountId()),
            trim((string) $this->request->getReference()),
            trim((string) $this->request->getParticular()),
            trim((string) $this->request->getCardType()),
            trim((string) $this->request->getAmount()),
            trim((string) $this->request->getResponseCode()),
            trim((string) $this->request->getResponseText()),
            trim((string) $this->request->getCustomerEmail()),
            trim((string) $this->request->getAuthorisationCode()),
            trim((string) $this->request->getErrorMessage()),
            trim((string) $this->request->getErrorCode()),
            trim((string) $this->request->getCustomData()),
            trim((string) $this->request->getCardToken()),
            trim((string) $this->request->getDate()),
            trim((string) $this->request->getCheckoutId()),
            trim((string) $this->request->getSessionId()),
            trim((string) $this->request->getBlockedReason()),
            trim((string) $this->request->getSecretKey())
        ];

        // Implement C# style hashing
        $strToHash = implode('', $data);
        $utfString = mb_convert_encoding($strToHash, "UTF-8");
        $hashTag = sha1($utfString, true);
        $base64Tag = base64_encode($hashTag);

        return $base64Tag === $this->data['payment_provider_verifier'];
    }
}
