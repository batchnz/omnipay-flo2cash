<?php
/**
 * Flo2Cash Abstract Request
 */

namespace Omnipay\Flo2Cash\Message;

use Omnipay\Common\ItemBag;
use Omnipay\Flo2Cash\Flo2CashItem;
use Omnipay\Flo2Cash\Flo2CashItemBag;

/**
 * Flo2Cash Abstract Request
 */
abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    // Public Methods
    // =========================================================================

    public function setCmd($value)
    {
        return $this->setParameter('cmd',  $value);
    }

    public function getCmd()
    {
         return $this->getParameter('cmd');
    }

    public function setAccountId($value)
    {
        return $this->setParameter('accountId',  $value);
    }

    public function getAccountId()
    {
         return $this->getParameter('accountId');
    }

    public function setAmount($value)
    {
        return $this->setParameter('amount',  $value);
    }

    public function getAmount()
    {
         return $this->getParameter('amount');
    }

    public function setItemName($value)
    {
        return $this->setParameter('itemName',  $value);
    }

    public function getItemName()
    {
         return $this->getParameter('itemName');
    }

    public function setReference($value)
    {
        return $this->setParameter('reference',  $value);
    }

    public function getReference()
    {
         return $this->getParameter('reference');
    }

    public function setParticular($value)
    {
        return $this->setParameter('particular',  $value);
    }

    public function getParticular()
    {
         return $this->getParameter('particular');
    }

    public function setReturnUrl($value)
    {
        return $this->setParameter('returnUrl',  $value);
    }

    public function getReturnUrl()
    {
         return $this->getParameter('returnUrl');
    }

    public function setNotificationUrl($value)
    {
        return $this->setParameter('notificationUrl',  $value);
    }

    public function getNotificationUrl()
    {
         return $this->getParameter('notificationUrl');
    }

    public function setHeaderImage($value)
    {
        return $this->setParameter('headerImage',  $value);
    }

    public function getHeaderImage()
    {
         return $this->getParameter('headerImage');
    }

    public function setHeaderBottomBorder($value)
    {
        return $this->setParameter('headerBottomBorder',  $value);
    }

    public function getHeaderBottomBorder()
    {
         return $this->getParameter('headerBottomBorder');
    }

    public function setHeaderBackgroundColour($value)
    {
        return $this->setParameter('headerBackgroundColour',  $value);
    }

    public function getHeaderBackgroundColour()
    {
         return $this->getParameter('headerBackgroundColour');
    }

    public function setCustomData($value)
    {
        return $this->setParameter('customData',  $value);
    }

    public function getCustomData()
    {
         return $this->getParameter('customData');
    }

    public function setStoreCard($value)
    {
        return $this->setParameter('storeCard',  $value);
    }

    public function getStoreCard()
    {
         return $this->getParameter('storeCard');
    }

    public function setDisplayCustomerEmail($value)
    {
        return $this->setParameter('displayCustomerEmail',  $value);
    }

    public function getDisplayCustomerEmail()
    {
         return $this->getParameter('displayCustomerEmail');
    }

    public function setPaymentMethod($value)
    {
        return $this->setParameter('paymentMethod',  $value);
    }

    public function getPaymentMethod()
    {
         return $this->getParameter('paymentMethod');
    }

    public function setMerchantVerifier($value)
    {
        return $this->setParameter('merchantVerifier',  $value);
    }

    public function getMerchantVerifier()
    {
         return $this->getParameter('merchantVerifier');
    }

    public function setSecretKey($value)
    {
        return $this->setParameter('secretKey',  $value);
    }

    public function getSecretKey()
    {
         return $this->getParameter('secretKey');
    }

    public function setReturnOption($value)
    {
        return $this->setParameter('returnOption',  $value);
    }

    public function getReturnOption()
    {
         return $this->getParameter('returnOption');
    }

    public function setUseShoppingCart($value)
    {
        return $this->setParameter('useShoppingCart',  $value);
    }

    public function getUseShoppingCart()
    {
         return $this->getParameter('useShoppingCart');
    }

    public function setCustomerInfoRequired($value)
    {
        return $this->setParameter('customerInfoRequired',  $value);
    }

    public function getCustomerInfoRequired()
    {
         return $this->getParameter('customerInfoRequired');
    }

    public function getBaseData()
    {
        $data = [];

        $data['cmd'] = $this->getUseShoppingCart() ?  '_xcart' : '_xclick';

        if( $this->getUseShoppingCart() && $this->getCustomerInfoRequired() ){
            $data['customer_info_required'] = '1';
        }

        return $data;
    }

    /**
     * Returns data for the items
     * @author Josh Smith <josh@batch.nz>
     * @return array
     */
    public function getItemData()
    {
        $data = [];
        $items = $this->getItems()->all();

        foreach ($items as $i => $item) {
            $pos = $i+1;
            $data["item_name$pos"] = $items[$i]->getName();
            $data["item_code$pos"] = $items[$i]->getCode();
            $data["item_price$pos"] = $items[$i]->getPrice();
            $data["item_qty$pos"] = $items[$i]->getQuantity();
        }

        return $data;
    }

    /**
     * Set the items in this order
     *
     * @param ItemBag|array $items An array of items in this order
     */
    public function setItems($items)
    {
        if ($items && !$items instanceof ItemBag) {
            $items = new Web2PayItemBag($items);
        }

        return $this->setParameter('items', $items);
    }

    /**
     * Calculates the merchange verifier property
     * @author Josh Smith <josh@batch.nz>
     * @return string
     */
    public function calcMerchantVerifier()
    {
        $data = [trim($this->getAccountId())];

        if( !$this->getUseShoppingCart() ){
            $data[] = trim($this->getAmount());
        } else {
            foreach ($this->getItemData() as $key => $value) {
                if( preg_match('/item_(price|qty)([0-9]+)/', $key) ){
                    $data[] = trim($value);
                }
            }
            $data[] = $this->getCustomerInfoRequired() ? '1' : '';
        }

        $data = array_merge($data, [
            trim($this->getReference()),
            trim($this->getParticular()),
            trim($this->getReturnUrl()),
            trim($this->getNotificationUrl()),
            trim($this->getCustomData()),
            trim($this->getPaymentMethod()),
            trim($this->getSecretKey())
        ]);

        // Implement C# style hashing
        $strToHash = implode('', $data);
        $utfString = mb_convert_encoding($strToHash, "UTF-8");
        $hashTag = sha1($utfString, true);
        $base64Tag = base64_encode($hashTag);

        return $base64Tag;
    }

    public function sendData($data)
    {
        return $this->createResponse($data);
    }

    // Protected Methods
    // =========================================================================

    protected function createResponse($data)
    {
        return $this->response = new Response($this, $data);
    }
}
